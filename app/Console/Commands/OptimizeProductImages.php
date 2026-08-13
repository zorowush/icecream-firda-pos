<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OptimizeProductImages extends Command
{
    protected $signature = 'products:optimize-images';

    protected $description = 'Optimize existing product images without changing database paths';

    public function handle()
    {
        $disk = Storage::disk('public');

        $manager = new ImageManager(new Driver());

        $files = $disk->files('products');

        if (empty($files)) {
            $this->info('Tidak ada gambar produk yang ditemukan.');
            return self::SUCCESS;
        }

        $processed = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($files as $file) {

            $extension = strtolower(
                pathinfo($file, PATHINFO_EXTENSION)
            );

            // Hanya proses JPG, JPEG, dan PNG lama.
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $skipped++;
                continue;
            }

            $temporaryFile = $file . '.tmp';

            try {

                $this->line("Memproses: {$file}");

                // Baca gambar asli
                $image = $manager->read(
                    $disk->get($file)
                );

                // Maksimal 1200 x 1200 px.
                // Gambar yang lebih kecil tidak diperbesar.
                $image->scaleDown(
                    width: 1200,
                    height: 1200
                );

                /*
                 * Simpan sebagai JPEG ke file sementara.
                 * Nama/path file asli tetap dipertahankan.
                 */
                $encoded = $image->toJpeg(
                    quality: 85
                );

                $disk->put(
                    $temporaryFile,
                    $encoded
                );

                // Pastikan file sementara berhasil dibuat
                if (!$disk->exists($temporaryFile)) {

                    throw new \RuntimeException(
                        'File sementara gagal dibuat.'
                    );
                }

                /*
                 * Ganti file lama dengan hasil optimasi.
                 *
                 * Path database TIDAK berubah.
                 */
                $disk->delete($file);

                $disk->move(
                    $temporaryFile,
                    $file
                );

                $processed++;

                $this->info(
                    "Berhasil: {$file}"
                );

            } catch (\Throwable $e) {

                // Bersihkan file sementara jika ada
                if ($disk->exists($temporaryFile)) {
                    $disk->delete($temporaryFile);
                }

                $failed++;

                $this->error(
                    "Gagal: {$file}"
                );

                $this->error(
                    $e->getMessage()
                );
            }
        }

        $this->newLine();

        $this->info('====================================');
        $this->info('Optimasi gambar selesai.');
        $this->info("Berhasil : {$processed}");
        $this->info("Dilewati : {$skipped}");
        $this->info("Gagal    : {$failed}");
        $this->info('====================================');

        return self::SUCCESS;
    }
}