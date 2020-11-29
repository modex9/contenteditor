<?php

namespace Classes;
use Tab, Module, Language;

abstract class PrototypeModule extends Module
{
    protected $tabs;
    protected $tables;

    public function install()
    {
        $res = true;
        $res &= $this->installAdminTabs();
        return $res && parent::install();
    }

    public function uninstall()
    {
        $res = true;
        $res &= $this->uninstallAdminTabs();
        return $res && parent::uninstall();
    }

    protected function getAdminTabs()
    {
        return $this->tabs;
    }

    protected function installAdminTabs()
    {
        $available_lang = Language::getLanguages();

        foreach ($this->getAdminTabs() as $tab)
        {
            $admin_tab = new Tab();
            $admin_tab->module = $this->name;
            $admin_tab->class_name = $tab['class_name'];
            $admin_tab->id_parent = Tab::getIdFromClassName($tab['id_parent']);
            $admin_tab->active = $tab['active'];

            foreach ($available_lang as $lang)
            {
                $admin_tab->name[$lang['id_lang']] = $tab['name'];
            }

            if (!$admin_tab->save())
            {
                $this->_errors[] = $this->l('Unable to install admin tab: '. $tab['class_name']);
                return false;
            }
        }
        return true;
    }

    protected function uninstallAdminTabs()
    {
        foreach ($this->getAdminTabs() as $tab)
        {
            $id_tab = Tab::getIdFromClassName($tab['class_name']);
            if ($id_tab)
            {
                $admin_tab = new Tab($id_tab);

                if (!Validate::isLoadedObject($admin_tab)) {
                    if (!$admin_tab->delete()) {
                        $this->_errors[] = $this->l('Unable to delete admin tab: ' . $tab['class_name']);
                        return false;
                    }
                }
            }
        }
        return true;
    }

}