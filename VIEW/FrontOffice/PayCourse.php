<?php
session_start();
require_once 'C:/xampp/htdocs/ProjetWeb/config.php';
require 'C:/xampp/htdocs/ProjetWeb/PayPal-PHP-SDK/autoload.php';

$clientId = 'AeCYZEPgFVFBhfg46-WqnccMMg0emNyMlvPooilDnX197m36Ykqp--a7cmp1xYigOHQEv3N5LbbPBD4M';
$clientSecret = 'EGpYlitJ13m56tM_aMGy9OmYjTQiXOmqkEcGjY2SS8SZoAccKcF-Kf8mSiQFP3C1kNp2DpYidv8I_Ruj';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        $clientId,
        $clientSecret
    )
);

try {
    // Check if redirected back with PayPal paymentId and PayerID
    if (isset($_GET['paymentId'], $_GET['PayerID'])) {
        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];

        // Execute payment
        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);

        $payment->execute($execution, $apiContext);

        echo "Payment executed successfully!"; // Or redirect to a success page
    } elseif (!empty($_POST['course_id'])) {
        $course_id = intval($_POST['course_id']); // Ensure course_id is an integer

        $db = config::getConnexion();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $courseSql = "SELECT course.id_form, course.nom_form, course.description, course.price, 
                             course.thumbnail_path, category.name AS category_name
                      FROM course 
                      LEFT JOIN category ON course.category_id = category.CategoryID
                      WHERE course.id_form = :course_id";

        $courseQuery = $db->prepare($courseSql);
        $courseQuery->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $courseQuery->execute();

        $course = $courseQuery->fetch(PDO::FETCH_ASSOC);

        if ($course) {
            $amount = number_format($course['price'], 2, '.', '');

            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');

            $amountDetails = new \PayPal\Api\Amount();
            $amountDetails->setTotal($amount)
                          ->setCurrency('USD'); // Use appropriate currency

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amountDetails)
                        ->setDescription('Payment for course: ' . $course['nom_form']);

            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl('http://localhost/ProjetWeb/VIEW/FrontOffice/payCourse.php') // Adjust return URL
                         ->setCancelUrl('http://localhost/ProjetWeb/VIEW/BackOffice/AddCategory.php'); // Cancel URL

            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions([$transaction])
                    ->setRedirectUrls($redirectUrls);

            $payment->create($apiContext);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() === 'approval_url') {
                    $redirectUrl = $link->getHref();
                    header('Location: ' . $redirectUrl);
                    exit; // Stop script execution after redirect
                }
            }
        } else {
            echo "Course not found.";
        }
    } else {
        echo "Invalid or missing course ID.";
    }
} catch (Exception $ex) {
    echo "Error: " . htmlspecialchars($ex->getMessage());
}
?>
