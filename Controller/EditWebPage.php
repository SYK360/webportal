<?php
/**
 * This file is part of webportal plugin for FacturaScripts.
 * Copyright (C) 2018  Carlos Garcia Gomez  <carlos@facturascripts.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace FacturaScripts\Plugins\webportal\Controller;

use FacturaScripts\Core\App\AppRouter;
use FacturaScripts\Core\Lib\ExtendedController;

/**
 * Description of EditWebPage
 *
 * @author Carlos García Gómez
 */
class EditWebPage extends ExtendedController\PanelController
{

    protected function createViews()
    {
        $this->addEditView('\FacturaScripts\Dinamic\Model\WebPage', 'EditWebPage', 'page', 'fa-globe');
    }

    public function getPageData()
    {
        $pageData = parent::getPageData();
        $pageData['menu'] = 'admin';
        $pageData['showonmenu'] = false;
        $pageData['icon'] = 'fa-globe';

        return $pageData;
    }

    protected function loadData($keyView, $view)
    {
        switch ($keyView) {
            case 'EditWebPage':
                $code = $this->request->get('code');
                $view->loadData($code);
                break;
        }
    }

    protected function execPreviousAction($view, $action)
    {
        if ($action === 'save') {
            $appRouter = new AppRouter();
            foreach ($this->views['EditWebPage']->getModel()->all() as $webpage) {
                if (empty($webpage->customcontroller)) {
                    $appRouter->setRoute('/' . $webpage->permalink, 'PortalHome', $webpage->idpage);
                    continue;
                }

                $appRouter->setRoute('/' . $webpage->permalink, $webpage->customcontroller, $webpage->idpage);
            }
        }

        return parent::execPreviousAction($view, $action);
    }

    protected function execAfterAction($view, $action)
    {
        switch ($action) {
            case 'preview':
                $model = $this->views['EditWebPage']->getModel();
                if ($model !== false) {
                    $this->response->headers->set('Refresh', '0; ' . $model->link());
                }
                break;

            default:
                parent::execAfterAction($view, $action);
        }
    }
}
