<?php

    /**
     * Created by PhpStorm.
     * User: Norgerman
     * Date: 12/20/14
     * Time: 2:15 PM
     */
    class PersoninfoController
        extends BaseController
    {
        public function getIndex()
        {
            return View::make('personinfo.index',array("logininfo" => parent::getLogininfo()));
        }
    }