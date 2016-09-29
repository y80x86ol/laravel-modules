<?php
/**
 * 文件系统
 */

namespace Y80x86ol\LaravelModules;


class FileSystem
{
    /**
     * 获取所有模块
     */
    public static function getAllModules()
    {
        $modulesPath = base_path() . '/app/Modules';

        $modulesNameList = [];
        if (file_exists($modulesPath)) {
            $directory = $modulesPath;
            $checkDir = dir($directory);
            while ($file = $checkDir->read()) {
                if ((is_dir("$directory/$file")) AND ($file != ".") AND ($file != "..")) {
                    $modulesNameList[] = $file;
                }
            }
        }
        return $modulesNameList;
    }
}