<?php

    /**
     * Created by PhpStorm.
     * User: Norgerman
     * Date: 12/14/14
     * Time: 1:13 PM
     */
    class IndexController
        extends BaseController
    {
        public function getIndex()
        {
            $besthos = Hospital::orderBy("zan", "desc")
                               ->take(4)
                               ->get();

            $notice = Notice::orderBy("n_id", "desc")
                            ->take(20)
                            ->get();

            return View::make("index.index", array("logininfo" => parent::getLogininfo(),
                                                   "besthos" => $besthos->toArray(),
                                                   "notice" => $notice->toArray()));
        }

        public function postLogin()
        {
            $username = Input::get("username");
            $password = Input::get("password");
            $result = array();
            if ($password == "" || $username == "")
            {
                $result["status"] = "empty";
            }
            else
            {
                $user = Registeruser::where("username", "=", $username)
                                    ->first();

                if ($user == null)
                {
                    $result["status"] = "-2";
                }
                else
                {
                    $pwd = hash("sha256", $password);
                    if ($pwd === $user->password)
                    {
                        Session::set("id", $user->id);
                        Session::set("type", "user");
                        Session::set("auth", $user->auth);
                        Session::set("username", $username);
                        $result["status"] = "1";
                        $result["username"] = $username;
                    }
                    else
                    {
                        $result["status"] = "-1";
                    }
                }
            }

            return Response::json($result);
        }

        public function getHospital()
        {
            $addr = Input::get("addr");
            $hos = Hospital::where("province", "=", $addr)
                           ->select("h_id", "name")
                           ->get()
                           ->toArray();

            return Response::json($hos);
        }

        public function getDepartment()
        {
            $h_id = Input::get("hospital_id");
            $dep = Department::where("hospital_id", "=", $h_id)
                             ->select("d_id", "name")
                             ->get()
                             ->toArray();

            return Response::json($dep);
        }

        public function postLogout()
        {
            Session::remove("id");
            Session::remove("type");
            Session::remove("auth");
            Session::remove("username");
        }
    }