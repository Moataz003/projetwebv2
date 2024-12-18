<?php
require_once 'C:/xampp/htdocs/Motaz/Controller/UtilisateursU.php';
require_once 'C:\xampp\htdocs\Motaz\fpdf186\fpdf.php';

// Récupérer les utilisateurs
$utilisateurController = new UtilisateursU();
$users = $utilisateurController->getUsersSorted('alphabetic'); // Tri par défaut

// Initialiser FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Titre
$pdf->Cell(0, 10, 'Liste des Utilisateurs', 0, 1, 'C');
$pdf->Ln(10);

// En-tête du tableau
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Nom', 1);
$pdf->Cell(60, 10, 'Email', 1);
$pdf->Cell(20, 10, 'Age', 1);
$pdf->Cell(40, 10, 'Ville', 1);
$pdf->Cell(20, 10, 'Role', 1);
$pdf->Ln();

// Contenu du tableau
$pdf->SetFont('Arial', '', 12);
foreach ($users as $user) {
    $pdf->Cell(50, 10, $user['Nom'], 1);
    $pdf->Cell(60, 10, $user['Email'], 1);
    $pdf->Cell(20, 10, $user['Age'], 1);
    $pdf->Cell(40, 10, $user['Ville'], 1);
    $pdf->Cell(20, 10, $user['Role'], 1);
    $pdf->Ln();
}

// Télécharger le PDF
$pdf->Output('D', 'Utilisateurs.pdf');
