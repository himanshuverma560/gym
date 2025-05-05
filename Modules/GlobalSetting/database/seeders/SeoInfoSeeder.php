<?php

namespace Modules\GlobalSetting\database\seeders;

use Illuminate\Database\Seeder;
use Modules\GlobalSetting\app\Models\SeoSetting;

class SeoInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeoSetting::truncate();

        $item1 = new SeoSetting();
        $item1->page_name = 'Home Page';
        $item1->seo_title = 'Home || TechNova';
        $item1->seo_description = 'Home || TechNova';
        $item1->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'About Page';
        $item2->seo_title = 'About || TechNova';
        $item2->seo_description = 'About || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Shop Page';
        $item2->seo_title = 'Shop || TechNova';
        $item2->seo_description = 'Shop || TechNova';
        $item2->save();

        $item3 = new SeoSetting();
        $item3->page_name = 'Contact Page';
        $item3->seo_title = 'Contact || TechNova';
        $item3->seo_description = 'Contact || TechNova';
        $item3->save();

        $item4 = new SeoSetting();
        $item4->page_name = 'Service Page';
        $item4->seo_title = 'Service || TechNova';
        $item4->seo_description = 'Service || TechNova';
        $item4->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Blog Page';
        $item2->seo_title = 'Blog Page || TechNova';
        $item2->seo_description = 'Blog Page || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'FAQ Page';
        $item2->seo_title = 'FAQ Page || TechNova';
        $item2->seo_description = 'FAQ Page || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Privacy & Policy Page';
        $item2->seo_title = 'Privacy & Policy || TechNova';
        $item2->seo_description = 'Privacy & Policy || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Terms & Condition Page';
        $item2->seo_title = 'Terms & Condition || TechNova';
        $item2->seo_description = 'Terms & Condition || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Workout Page';
        $item2->seo_title = 'Workout || TechNova';
        $item2->seo_description = 'Workout || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Trainer Page';
        $item2->seo_title = 'Trainer || TechNova';
        $item2->seo_description = 'Trainer || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Image Gallery Page';
        $item2->seo_title = 'Image Gallery || TechNova';
        $item2->seo_description = 'Image Gallery || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Video Gallery Page';
        $item2->seo_title = 'Video Gallery || TechNova';
        $item2->seo_description = 'Video Gallery || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Award Page';
        $item2->seo_title = 'Award || TechNova';
        $item2->seo_description = 'Award || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Pricing Page';
        $item2->seo_title = 'Pricing || TechNova';
        $item2->seo_description = 'Pricing || TechNova';
        $item2->save();
        $item2 = new SeoSetting();
        $item2->page_name = 'Cart Page';
        $item2->seo_title = 'Cart || TechNova';
        $item2->seo_description = 'Cart || TechNova';
        $item2->save();

        $item2 = new SeoSetting();
        $item2->page_name = 'Checkout Page';
        $item2->seo_title = 'Checkout || TechNova';
        $item2->seo_description = 'Checkout || TechNova';
        $item2->save();


        $item2 = new SeoSetting();
        $item2->page_name = 'Payment Page';
        $item2->seo_title = 'Payment || TechNova';
        $item2->seo_description = 'Payment || TechNova';
        $item2->save();


        $item2 = new SeoSetting();
        $item2->page_name = 'Wishlist Page';
        $item2->seo_title = 'Wishlist || TechNova';
        $item2->seo_description = 'Payment || TechNova';
        $item2->save();
    }
}
