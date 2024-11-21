<?php
class Utilisateurs extends Controller
{
    public function __construct()
    {
        $this->employeModel = $this->model('Utilisateurs');
    }

    public function ajouter_utilisateurs()
    {
        $data = [
            'Id_user' => '',
            'Nom' => '',
            'Prenom' => '',
            'Age' => '',
            'Ville' => '',
            'Num_tel' => '',
            'Email' => '',
            'Role' => '',
            'errorAdd' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'Id_user' => trim($_POST['Id_user']),
                'Nom' => trim($_POST['Nom']),
                'Prenom' => trim($_POST['Prenom']),
                'Age' => trim($_POST['Age']),
                'Ville' => trim($_POST['Ville']),
                'Num_tel' => trim($_POST['Num_tel']),
                'Email' => trim($_POST['Email']),
                'Role' => trim($_POST['Role']),
                'errorAdd' => ''
            ];

            $nameValidation = "/^[a-z ,.'-]+$/i";
            $idValidation = "/^[0-9]{6}$/";


            //Validate id on numbers
            if (empty($data['Id_user'])) {
                $data['errorAdd'] = 'Please enter id.';
            } elseif (!is_numeric($data['Id_user'])) {
                $data['errorAdd'] = 'id can only contain numbers.';
            } elseif (!preg_match($idValidation, $data['Id_user'])) {
                $data['errorAdd'] = 'id should be composed of 6 numbers.';
            } else {
                if ($this->employeModel->rechercher_id($data['Id_user'])) {
                    $data['errorAdd'] = 'Id_user is already taken.';
                }
            }

            //Validate nom
            if (empty($data['Nom'])) { //check if name is empty or not
                $data['errorAdd'] = 'Please enter your name.';
            } elseif (!preg_match($nameValidation, $data['Nom'])) { //check name regex
                $data['errorAdd'] = 'Please enter your real name.';
            }

            if (empty($data['Prenom'])) {
                $data['errorAdd'] = 'Please enter your surname.';
            } elseif (!preg_match($nameValidation, $data['Prenom'])) {
                $data['errorAdd'] = 'Please enter your real surname.';
            }

            if (empty($data['Ville'])) {
                $data['errorAdd'] = 'Please enter a town.';
            } elseif (!preg_match($nameValidation,$data['Ville'])) {
                $data['errorAdd'] = 'Town can only contain letters.';
            }

            // Make sure that errors are empty
            if (empty($data['errorAdd'])) {

                //add employe from model function
                if (!$this->employeModel->ajouter_utilisateurs($data)) {
                    die('Something went wrong.');
                } else
                    $this->view('Utilisateurs');
            } else {
                $errorTab = explode(" ", $data['errorAdd']);
                $err = implode("-", $errorTab);
                $this->afficherList("err-" . $err);
            }
        } else
            $this->view('Utilisateurs');
    }


    public function afficher_List($error = '')
    {
        $tab = $this->employeModel->afficher();
        $data = [
            'tab' => '',
            'errorAdd' => '',
            'errorUpdate' => '',
            'sup' => '',
            'inf' => '' 
        ];


        if (isset($error)) {
            $errorTab = explode("-", $error);
            if ($errorTab[0] == 'err') {
                array_shift($errorTab);
                $data['errorAdd'] = implode(" ", $errorTab);
            } else if ($errorTab[0] == 'errUp') {
                array_shift($errorTab);
                $data['errorUpdate'] = implode(" ", $errorTab);
            } else {
                $data['errorAdd'] = '';
                $data['errorUpdate'] = '';
            }
        }


        foreach ($tab as $key => $value) {
            $data['tab'] .= '<li class="table-row">
            <div class="col col-1" data-label="Id_user">' . $value[0] . '</div>
            <div class="col col-2" data-label="Nom">' . $value[1] . '</div>
            <div class="col col-3" data-label="Prenom">' . $value[2] . '</div>
            <div class="col col-4" data-label="Age">' . $value[3] . '</div>
            <div class="col col-5" data-label="Ville">' . $value[4] . '</div>
            <div class="col col-5" data-label="Num_tel">' . $value[4] . '</div>
            <div class="col col-6" data-label="Email">' . $value[5] . '</div>
            <div class="col col-6" data-label="Role">' . $value[5] . '</div>
            <div class="col col-7">
                <div class="col-buttons">
                    <button class="tab-btn"><i data-feather="edit"></i></button>
                </div>
            </div>
        </li>';
        }

        $this->view('Utilisateurs', $data);
    }

    public function deleteUpdateTab()
    {
        if (isset($_POST['delete'])) {
            $this->employeModel->supprimer_utilisateurs($_POST['Id_user']);
            header('location:localhost/Motaz/Views/Back_Office/afficherUtilisateurs.php');
        } elseif (isset($_POST['update'])) {
            $data = [
                'Id_user',
                'Id_user' => '',
                'Nom' => '',
                'Prenom' => '',
                'Age' => '',
                'Ville' => '',
                'Num_tel' => '',
                'Email' => '',
                'Role' => '',
                'errorUpdate' => ''
            ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'Id_user' => trim($_POST['Id_user']),
                    'Nom' => trim($_POST['Nom']),
                    'Prenom' => trim($_POST['Prenom']),
                    'Age' => trim($_POST['Age']),
                    'Ville' => trim($_POST['Ville']),
                    'Num_tel' => trim($_POST['Num_tel']),
                    'Email' => trim($_POST['Email']),
                    'Role' => trim($_POST['Role']),
                    'errorUpdate' => ''
                ];

                $idValidation = "/^[0-9]{5}$/";

                if (empty($data['Id_user'])) {
                    $data['errorUpdate'] = 'tapez votre Id.';
                } elseif (!is_numeric($data['Id_user'])) {
                    $data['errorUpdate'] = 'Id se compose uniquement de chiffres.';
                } elseif (!preg_match($idValidation, $data['Id_user'])) {
                    $data['errorAdd'] = 'Id se compose de exactement 6 chiffres.';
                } else {
                    if ($this->employeModel->rechercher_id($data['Id_user'])) {
                        $data['errorUpdate'] = 'Id existe deja.';
                    }
                }

                //Validate nom
                if (empty($data['Nom'])) { //check if name is empty or not
                    $data['errorUpdate'] = 'tapez votre nom.';
                } elseif (!ctype_alpha($data['Nom'])) { //check name regex
                    $data['errorUpdate'] = 'tapez votre vrai nom.';
                }

                if (empty($data['Prenom'])) {
                    $data['errorUpdate'] = 'tapez votre prenom.';
                } elseif (!ctype_alpha($data['Prenom'])) {
                    $data['errorUpdate'] = 'tapez votre vrai prenom.';
                }

                if (empty($data['Age'])) {
                    $data['errorUpdate'] = 'tapez votre age.';
                } elseif (!is_numeric($data['Age'])) {
                    $data['errorUpdate'] = 'age contient que des chiffres.';
                }

                $email = "Email";
               if ( preg_match ( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $email ) )
                {
                echo "L'adresse Email est valide";
                }
                
                // Make sure that errors are empty
                if (empty($data['errorUpdate'])) {

                    //add employe from model function
                    if (!$this->ouvrierModel->modifier_utilisateurs($data)) {
                        die('Erreur.');
                    } else
                        $this->view('Utilisateurs');
                } else {
                    $errorTab = explode(" ", $data['errorUpdate']);
                    $err = implode("-", $errorTab);
                    $this->afficherList("errUp-" . $err);
                }
            } else
                $this->view('Utilisateurs');
        } else
            $this->view('Utilisateurs');
    }
}