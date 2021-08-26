<?php

namespace app\core\module;

use app\core\Application;
use app\core\module\exception\ModuleLoaderException;

class ModuleManager
{
    /** @var array<string, \app\core\module\AModule> */
    protected array $moduleList = [];

    /**
     * Инициализирует систему модулей.
     *
     * @throws \app\core\module\exception\ModuleLoaderException
     */
    public function init(): void
    {
        $filePath = $this->getModuleListFilePath();

        if (!is_readable($filePath)) {
            return;
        }

        $moduleList = require_once $filePath;

        foreach ($moduleList as $moduleName) {
            $filePath = $this->getModuleClassFile($moduleName);

            if (!is_readable($filePath)) {
                throw new ModuleLoaderException("Cannot read file '{$filePath}' from '{$moduleName}' module");
            }

            require_once $filePath;

            $moduleClass = $this->getModuleClass($moduleName);

            if (!class_exists($moduleClass)) {
                throw new ModuleLoaderException("Cannot find class '{$moduleClass}' from '{$moduleName}' module");
            }

            $this->initModule(new $moduleClass);
        }
    }

    protected function initModule(AModule $module): void
    {

    }

    /**
     * Возвращает абсолютный путь к файлу со списком активных модулей.
     *
     * @return string
     */
    protected function getModuleListFilePath(): string
    {
        return Application::getInstance()->getAbsRootDirectory() . DIRECTORY_SEPARATOR . 'modules.php';
    }

    /**
     * Возвращает абсолютный путь к директории модуля.
     *
     * @param string $moduleName
     *
     * @return string
     */
    protected function getModuleDir(string $moduleName): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            Application::getInstance()->getAbsRootDirectory(),
            'modules',
            $moduleName,
        ]);
    }

    /**
     * Возвращает абсолютный путь к классу модуля.
     *
     * @param string $moduleName
     *
     * @return string
     */
    protected function getModuleClassFile(string $moduleName): string
    {
        return $this->getModuleDir($moduleName) . DIRECTORY_SEPARATOR . $this->getModuleClassName($moduleName) . '.php';
    }

    /**
     * Возвращает название класса модуля.
     *
     * @param string $moduleName
     *
     * @return string
     */
    protected function getModuleClassName(string $moduleName): string
    {
        return ucfirst($moduleName).'Module';
    }

    /**
     * @param string $moduleName
     *
     * @return class-string
     */
    protected function getModuleClass(string $moduleName): string
    {
        return "modules\\$moduleName\\".$this->getModuleClassName($moduleName);
    }
}