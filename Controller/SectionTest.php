<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace FacturaScripts\Plugins\webportal\Controller;

use FacturaScripts\Plugins\webportal\Lib\WebPortal\SectionController;

/**
 * Description of SectionTest
 *
 * @author carlos
 */
class SectionTest extends SectionController
{

    protected function createSections()
    {
        $this->addListSection('ListProducto', 'Producto', 'products', 'fas fa-cubes');
        $this->addSearchOptions('ListProducto', ['referencia', 'descripcion']);
        $this->addOrderOption('ListProducto', ['referencia'], 'reference');

        $newButton = [
            'action' => 'EditProducto',
            'icon' => 'fas fa-plus',
            'label' => 'new',
            'level' => 1,
            'tag' => 'button',
            'type' => 'link',
        ];
        $this->addButton('ListProducto', $newButton);

        $this->addListSection('ListAsiento', 'Asiento', 'accounting-entries');
        $this->addSearchOptions('ListAsiento', ['numero', 'concepto']);
        $this->addOrderOption('ListAsiento', ['numero'], 'numero');

        $this->addListSection('ListFabricante', 'Fabricante', 'manufacturers', 'fas fa-columns');
        $this->addListSection('ListFamilia', 'Familia', 'families', 'fas fa-object-group');
    }

    protected function loadData(string $sectionName)
    {
        $this->sections[$sectionName]->loadData();
    }
}
