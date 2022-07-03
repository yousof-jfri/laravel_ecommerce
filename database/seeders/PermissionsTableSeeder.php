<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'show-users',
                'label' => 'نشان دادن کاربران'
            ],
            [
                'name' => 'add-user',
                'label' => 'اضافه کردن کاربر جدید',
            ],
            [
                'name' => 'edit-user',
                'label' => 'تغییر دادن کاربر',
            ],
            [
                'name' => 'delete-user',
                'label' => 'حذف کردن کاربر',
            ],
            [
                'name' => 'set-permission-role-to-user',
                'label' => 'اجازه دادن کاربر برای تغییر دسترسی ها و قوانین',
            ],
            [
                'name' => 'show-categories',
                'label' => 'نشان دادن دسته بندی ها',
            ],
            [
                'name' => 'edit-category',
                'label' => 'تغییر دسته بندی',
            ],
            [
                'name' => 'add-category',
                'label' => 'افزودن دسته بندی',
            ],
            [
                'name' => 'delete-category',
                'label' => 'حذف دسته بندی',
            ],
            [
                'name' => 'add-product',
                'label' => 'اضافه کردن محصول',
            ],
            [
                'name' => 'edit-product',
                'label' => 'تغییر محصول',
            ],
            [
                'name' => 'delete-product',
                'label' => 'حذف کردن محصول',
            ],
            [
                'name' => 'show-products',
                'label' => 'مشاهده کردن محصول',
            ],
            [
                'name' => 'show-comments',
                'label' => 'نشان دادن نظرات',
            ],
            [
                'name' => 'delete-comment',
                'label' => 'حذف کردن نظر',
            ],
            [
                'name' => 'approve-comment',
                'label' => 'تایید نظر',
            ],
            [
                'name' => 'add-attribute',
                'label' => 'اضافه کردن ویژه گی',
            ],
            [
                'name' => 'delete-attribute',
                'label' => 'حذف ویژه گی',
            ],
            [
                'name' => 'show-attributes',
                'label' => 'دیدن ویژه گی ها',
            ],
            [
                'name' => 'acl-control',
                'label' => 'کنترل کامل بر سیستم کنترل دسترسی',
            ],
            [
                'name' => 'show-dashboard',
                'label' => 'دیدن پنل مدیریت'
            ]
        ];

        foreach($permissions as $permission){
            Permission::create([
                'name' => $permission['name'],
                'label' => $permission['label'],
            ]);
        }

        
    }
}
