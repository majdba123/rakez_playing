<?php

namespace App\Console\Commands;

use App\Models\Projects;
use App\Models\ProjectUpload;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportProjects extends Command
{
    protected $signature = 'projects:import';
    protected $description = 'Remove all old projects and import new ones from CSV file';

    public function handle()
    {
        $this->info('بدء استيراد المشاريع...');

        $staticFileName = 'projects.csv';
        $filePath = Storage::disk('public')->path('projects/' . $staticFileName);

        // Check if file exists
        if (!file_exists($filePath)) {
            $this->error("لم يتم العثور على ملف المشاريع: {$staticFileName}");
            return 1;
        }

        try {
            // Step 1: Delete all old projects
            $this->info('جاري حذف المشاريع القديمة...');
            $deletedCount = Projects::query()->delete();
            $this->info("تم حذف {$deletedCount} مشروع قديم.");

            // Step 2: Import new projects from CSV
            $this->info('جاري استيراد المشاريع الجديدة من ملف CSV...');

            $importedCount = 0;
            $skippedCount = 0;
            $rowNumber = 0;

            // Open file with proper encoding for Arabic
            $file = fopen($filePath, 'r');

            if (!$file) {
                throw new \Exception("لا يمكن فتح ملف CSV.");
            }

            // Skip header row
            $header = fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $rowNumber++;

                // Skip empty rows
                if (empty($row) || (count($row) === 1 && empty($row[0]))) {
                    continue;
                }

                try {
                    // Map CSV columns to project fields
                    $projectData = [
                        'name' => trim($row[0] ?? ''),          // Column 0: Name
                        'type' => trim($row[1] ?? 'apartment'),   // Column 1: Type
                        'value_discount' => floatval($row[2] ?? 0),   // Column 2: Value Discount
                        'type_discount' => trim($row[3] ?? 'fixed'), // Column 3: Type Discount
                    ];

                    // Validate required fields
                    if (empty($projectData['name'])) {
                        $skippedCount++;
                        $this->warn("تم تخطي الصف {$rowNumber}: اسم المشروع مفقود");
                        continue;
                    }

                    // Validate and fix type
                    $validTypes = ['apartment', 'floor', 'unit'];
                    if (!in_array($projectData['type'], $validTypes)) {
                        $projectData['type'] = 'apartment';
                    }

                    // Validate and fix type_discount
                    $validDiscountTypes = ['percentage', 'fixed'];
                    if (!in_array($projectData['type_discount'], $validDiscountTypes)) {
                        $projectData['type_discount'] = 'fixed';
                    }

                    // Validate value_discount for percentage
                    if ($projectData['type_discount'] === 'percentage' && $projectData['value_discount'] > 100) {
                        $projectData['value_discount'] = 100;
                    }

                    // Ensure value_discount is not negative
                    if ($projectData['value_discount'] < 0) {
                        $projectData['value_discount'] = 0;
                    }

                    // Check if project name already exists (to avoid duplicates)
                    $existingProject = Projects::where('name', $projectData['name'])->first();
                    if ($existingProject) {
                        $skippedCount++;
                        $this->warn("تم تخطي الصف {$rowNumber}: المشروع '{$projectData['name']}' موجود مسبقاً");
                        continue;
                    }

                    // Create project
                    Projects::create($projectData);
                    $importedCount++;

                    // Show progress
                    if ($rowNumber % 10 === 0) {
                        $this->info("تم معالجة {$rowNumber} صف...");
                    }

                } catch (\Exception $e) {
                    $skippedCount++;
                    $this->warn("خطأ في الصف {$rowNumber}: " . $e->getMessage());
                }
            }

            fclose($file);

            // Record the upload
            ProjectUpload::create([
                'file_name' => $staticFileName,
                'projects_count' => $importedCount
            ]);

            $this->info("\n✅ تم الاستيراد بنجاح!");
            $this->info("📊 تم استيراد: {$importedCount} مشروع");
            $this->info("🚫 تم تخطي: {$skippedCount} صف");
            $this->info("📁 إجمالي الصفوف المعالجة: {$rowNumber} صف");

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ فشل الاستيراد: " . $e->getMessage());
            return 1;
        }
    }
}
