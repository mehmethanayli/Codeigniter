<?php
class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("User_Model");
    }

    public function index()
    {
        $users = $this->User_Model->get_all("created_at DESC");
        $viewData = new stdClass();
        $viewData->users = $users;
        $this->load->view("Users_v", $viewData);
    }
    public function save()
    {
        /* Kütüphane Önyükleme İşlemi */
        $this->load->library("form_validation");

        /* Kurallar Yazılır */
        $this->form_validation->set_rules("name", "Kullanıcının İsmi ", "required|trim");
        $this->form_validation->set_rules("surname", "Kullanıcının Soyismi ", "required|trim");
        $this->form_validation->set_rules("email", "Kullanıcının Email Adresi", "required|trim|valid_email|is_unique[users.email]");
        $this->form_validation->set_rules("password", "Parola ", "required|trim");
        $this->form_validation->set_rules("re-password", "Parola Tekrarı ", "required|trim|matches[password]");


        /* Hata Mesajlarını */
        $this->form_validation->set_message(
            array(
                "required"      => "<b>{field} </b> alanı doldurulmalıdır.",
                "valid_email"   => "<b>{field} </b> alanı geçerli bir email adresi değildir.",
                "is_unique"     => "<b>{field} </b> alanı daha önceden veri tabanında kayıtlıdır.",
                "matches"       => "<b>{field} </b> şifreler birbiriyle eşleşmiyor."
            )
        );


        /* Validasyon işlemi kurallara göre çalıştırılır. */
        $validation = $this->form_validation->run();

        if ($validation) {
            $data = array(
                "name"      => $this->input->post("name"),
                "surname"   => $this->input->post("surname"),
                "email"     => $this->input->post("email"),
                "password"  => md5($this->input->post("password"))
            );

            $insert = $this->User_Model->add($data);

            if ($insert) {
                echo "Kayıt Başarılı";
            } else {
                echo "Kayıt Başarısız";
            }
        } else {

            $viewData = new stdClass();
            $viewData->formError = true;
            $this->load->view("Users_v", $viewData);
        }
    }

    public function getAll()
    {
        $users = $this->User_Model->get_all("created_at DESC");
        echo "<pre>";
        print_r($users);
        echo "</pre>";
    }

    public function get()
    {
        $user = $this->User_Model->get(
            array(
                "email"     => "asd@asd.com",
                "is_active" => 1
            )
        );
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    }
}
