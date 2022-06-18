    <?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['korisnik']) && $_SESSION['korisnik']->id_uloga == 1){
        include_once '../config/connection.php';
        include_once 'functions.php';
        header('Content-type: application/json');
        $survey = dohvatiSveAnkete();
        $ispis = '<div>';
        if($survey){
            $broj = 1;
            $ispis = '<h3 class="mt-0 mt-xl-5">All surveys</h3>';
            $ispis.= '<div class="table-responsive"><table class="table table-hover">';
            $ispis.='<thead class="thead-dark">';
            $ispis.='<th>#</th>';
            $ispis.='<th>Question</th>';
            $ispis.='<th>Status</th>';
            $ispis.='<th>Delete</th>';
            $ispis.='</tr></thead class="thead-dark">';
            foreach ($survey as $sub){
                if($sub->active){
                    $active = '<button type="button" class="btn btn-primary">Active</button>';
                }
                else{
                    $active = '<button type="button" class="btn btn-dark activate" data-survey="'.$sub->id.'">Click to activate</button>';
                }
                $ispis.='<tr>';
                $ispis.='<td>'.$broj++.'</td>';
                $ispis.='<td>'.$sub->pitanje.'</td>';
                $ispis.='<td>'.$active.'</td>';
                if(!$sub->active){
                    $ispis.='<td><button type="button" class="btn btn-danger deleteSurvey" data-survey="'.$sub->id.'">Delete</button></td>';
                }
                else{
                    $ispis.='<td>Survey is active.</td>';
                }
            }
            $ispis.='</table></div>';
            http_response_code(200);
            echo json_encode($ispis);
        }
        else{
            http_response_code(500);
            $odgovor = ['msg' => 'There are no surveys to show.'];
            echo json_encode($odgovor);
        }
    }
    else{
        header('Location: ../error404.php');
    }
