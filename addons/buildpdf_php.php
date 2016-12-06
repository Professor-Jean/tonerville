<?php
  // incluindo o mpdf
  include_once("mpdf/mpdf.php");
  // pega o conteudo a ser transformado em pdf por POST
  $pdf_body .= "<div id='content'>";
  $pdf_body .= $_POST['dadospdf'];
  $pdf_body .= "</div>";
  // criando um cabeçalho
  $pdf_header ='
  <table>
    <tr>
      <th rowspan="4" style="padding-right: 50px;">
        <img height="80px" src="../layout/images/logo_header.png" title="logo">
      </th>
      <td>Tonerville</td>
    </tr>
    <tr>
      <td>Endereço: Rua Xavantes, 155 - Atiradores - Joinville, SC - CEP 89203-210</td>
    </tr>
    <tr>
      <td>Telefone: (47) 3438-0202 / 9974-0270</td>
    </tr>
    <tr>
      <td>E-mail: tonerville@tonerville.com.br</td>
    </tr>
  </table><hr>
  ';
  // criando um rodapé
  $pdf_footer ='
  <hr>
  <table width="100%" id="footer">
    <tr>
      <td align="center">{DATE j/m/Y}</td>
      <td align="center">{PAGENO}/{nbpg}</td>
      <td align="center">Tonerville</td>
    </tr>
  </table>
  ';

  // criando o pdf
  $mpdf = new mPDF('c', 'A4', '', '', 20, 15, 48, 25, 10, 10); // setando algumas configurações do mpdf
  $mpdf->SetHTMLHeader($pdf_header); // inserindo o cabeçalho
  $mpdf->SetHTMLFooter($pdf_footer); // inserindo o rodapé
  $stylesheet_admin = file_get_contents("../layout/css/guest_css.css");
  $mpdf->WriteHTML($stylesheet_admin,1); // inserindo o css
  $mpdf->WriteHTML($stylesheet_guest,2);
  $mpdf->WriteHTML($pdf_body,3); // inserindo o corpo
  $mpdf->output(); // gerando o pdf
