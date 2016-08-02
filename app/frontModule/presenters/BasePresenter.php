<?php

namespace BaseModule\Presenters;

use Components\EntityForm;
use Model;
use Nette;
use Nette\Application\UI\Presenter;
use Nette\Localization\ITranslator;
use Nette\Utils\ArrayHash;


abstract class BasePresenter extends Presenter
{
    protected $is_dev_server;

    public $neon;
    public $flash;
    public $word;

    public function startup()
    {
        parent::startup();

        $this->setServerGlobalForCI();

        $this->template->id_div = $this->getDivId();

//        $this->template->neon = $this->neon = ArrayHash::from($this->context->parameters);
//        $this->template->word = $this->word = ArrayHash::from($this->neon->words);
//        $this->template->is_dev_server = $this->is_dev_server = $this->isDevServer();
//        $this->flash = ArrayHash::from($this->neon->flashes);

    }

    public function actionSignOut()
    {
        $this->user->logout();
        $this->flashMessage($this->flash->sign_out);
        $this->redirect(':Front:Default:');
    }


    //////////////////////////// PRIVATE

    private function getDivId()
    {
        $module_presenter_name = explode(':', $this->getName());

        $presenter = isset($module_presenter_name[1]) ? strtolower($module_presenter_name[1]) : '';
        $action = strtolower($this->getAction());

        return $presenter . '-' . $action;
    }

    private function setMaintenance()
    {
        if($this->getAction() != 'e500') {
            $this->redirect(':Base:ErrorTest:e500');
        }
    }

    protected function createTemplate()
    {
        $template = parent::createTemplate();

        $template->addFilter(null, 'Filters::common');

        return $template;
    }

    private function setServerGlobalForCI()
    {
        if(!isset($_SERVER['HTTP_HOST'])){ // pro CI
            $_SERVER['HTTP_HOST'] = 'localhost';
            $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        }
    }


    private function isDevServer()
    {
        return isset($_SERVER['HTTP_HOST']) && in_array($_SERVER['HTTP_HOST'], (array)$this->neon->dev_servers) ? true : false;
    }



}
