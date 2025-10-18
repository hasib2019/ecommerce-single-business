<?php

namespace App\Services\Menu;

use Illuminate\Support\Facades\DB;

class Menu
{
    protected $table_prefix = 'admin_';
    protected $table_name_menus = 'menus';
    protected $table_name_items = 'menu_items';

    public function __construct()
    {
        // Get values from config
        $this->table_prefix = config('menu.table_prefix');
        $this->table_name_menus = config('menu.table_name_menus');
        $this->table_name_items = config('menu.table_name_items');
    }

    /**
     * Get menu by ID
     *
     * @param int $menu_id
     * @return array
     */
    public function get($menu_id)
    {
        $menuItems = DB::table($this->table_prefix . $this->table_name_items)
            ->select('*')
            ->where('menu', $menu_id)
            ->orderBy('sort', 'ASC')
            ->get()
            ->toArray();

        return $this->parseMenuItems($menuItems);
    }

    /**
     * Get menu by name
     *
     * @param string $menu_name
     * @return array
     */
    public function getByName($menu_name)
    {
        $menu = DB::table($this->table_prefix . $this->table_name_menus)
            ->select('id')
            ->where('name', $menu_name)
            ->first();

        if (!$menu) {
            return [];
        }

        return $this->get($menu->id);
    }

    /**
     * Get all categories from categories table
     *
     * @return array
     */
    public function getAllCategories()
    {
        $categories = DB::table('categories')
            ->select('id', 'categoryName', 'categorySlug', 'categoryImage')
            ->where('status', 'Active')
            ->orderBy('categoryName', 'ASC')
            ->get()
            ->toArray();

        $parsed = [];
        foreach ($categories as $category) {
            $parsed[] = [
                'id' => $category->id,
                'label' => $category->categoryName,
                'link' => url('shop?cat_id=' . $category->id),
                'slug' => $category->categorySlug,
                'image' => $category->categoryImage
            ];
        }

        return $parsed;
    }

    /**
     * Parse menu items into a hierarchical structure
     *
     * @param array $menuItems
     * @return array
     */
    protected function parseMenuItems($menuItems)
    {
        $parsed = [];
        $parents = [];

        // First pass: identify all items with parent = 0 (top level)
        foreach ($menuItems as $item) {
            if ($item->parent == 0) {
                $parsed[] = [
                    'id' => $item->id,
                    'label' => $item->label,
                    'link' => $item->link,
                    'parent' => $item->parent,
                    'sort' => $item->sort,
                    'child' => []
                ];
                $parents[] = $item->id;
            }
        }

        // Second pass: add children to their respective parents
        foreach ($menuItems as $item) {
            if ($item->parent != 0) {
                foreach ($parsed as &$parsedItem) {
                    if ($parsedItem['id'] == $item->parent) {
                        $parsedItem['child'][] = [
                            'id' => $item->id,
                            'label' => $item->label,
                            'link' => $item->link,
                            'parent' => $item->parent,
                            'sort' => $item->sort
                        ];
                    }
                }
            }
        }

        return $parsed;
    }

    /**
     * Render menu for admin panel
     *
     * @return string
     */
    public function render()
    {
        // This is a simplified version - in a real implementation, you would
        // render the admin interface for managing menus
        return view('admin.menu')->render();
    }

    /**
     * Get scripts for admin panel
     *
     * @return string
     */
    public function scripts()
    {
        // This is a simplified version - in a real implementation, you would
        // return the necessary JavaScript for the admin interface
        return '<script>console.log("Menu scripts loaded");</script>';
    }
}