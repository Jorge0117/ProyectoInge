<?php
namespace App\Controller;

use App\Controller\AppController;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Database\Exception;

/**
 * Requirements Controller
 *
 * @property \App\Model\Table\RequirementsTable $Requirements
 *
 * @method \App\Model\Entity\Requirement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{

    /**
     * approved_Student_report
     * 
     * @return 
     */

    public function studentRequests(){
        $table = $this->loadModel('ProfessorAssistants');

        $studentRequests = $table->find()->where(['id_student'=>$this->viewVars['current_user']['identification_number']]);
        if(count($studentRequests->toArray()) > 0){
            //Obtiene el nombre del profesor al que le solicitó la asistencia
            $user= new UsersController;
            $idProf = $studentRequests->toArray()[0]->id_prof;
            $ProfessorName = $user->getNameUser($idProf);
        }
        $this->set(compact('studentRequests', 'ProfessorName'));
    }
    

    /** 
     * Autor: Mayquely
     */
    public function professorAssistants(){
        $table = $this->loadModel('ProfessorAssistants');
         $professorAssistants= $table->find()->where(['id_prof'=>$this->viewVars['current_user']['identification_number']]);
         $ProfessorName = ' '; 

        if(count($professorAssistants->toArray()) > 0){
           
            $user= new UsersController;
            $idProf = $professorAssistants->toArray()[0]->id_prof;
            $ProfessorName = $user->getNameUser($idProf);

        }
        
        $this->set(compact('professorAssistants',   'ProfessorName' ));
    }

    public function getRoundByValues($round,$semester,$year)
    {
		if($semester == 1)
			$semester = 'I';
		else if($semester == 2)
			$semester = 'II';
		
        //Debe comunicarse con rondas
		$rounds_c = new RoundsController;
        return $rounds_c->get_round_key($round,$semester,$year); //
    }

    public function reportsView($parametro = null){
		
		$report =  explode("t",$parametro);
		
		$llave_ronda = '\'' . $report[0] .'\'';		
		$tipo = $report[1];
		$aprobadas = 0;
		$horas = 0;
		$imprimirEstado = 0;
		//Se basa en el tipo paraelegir que parametro realizar
		switch($tipo)
		{
			case 1:
				//Imprime aprobadas
				//$table = $this->loadModel('info_requests');
                $estado = '\'a\'';
				$solicitudes = new RequestsController;
                //$report= $table->find()->where(['inicio = ' . $llave_ronda . ' AND estado = ' . $estado]);
				$report = $solicitudes->getApprovedRequestsByRound($llave_ronda);
				$titulo = 'aprobadas';
				//$report = $this->Reports->getApprovedByRound($llave_ronda);
				$horas = 1;
				break;
			case 2:
				//Imprime elegibles rechazados
				$table = $this->loadModel('info_requests');  
                $estado = 'r';
               // $report= $table->find()->where(['inicio = ' . $llave_ronda . ' AND estado = ' . $estado]);
			   $solicitudes = new RequestsController;
			   $report = $solicitudes->getRequestsByRoundStatus($llave_ronda,$estado);
				$titulo = 'elegibles rechazadas';
				break;
			case 3:
				//Imprime no elegibles
				$table = $this->loadModel('info_requests');  
                $estado = 'n';
				$solicitudes = new RequestsController;
			    $report = $solicitudes->getRequestsByRoundStatus($llave_ronda,$estado);
				$titulo = 'no elegibles';
				break;
			case 4:
				//Imprime resultados de una ronda
				$table = $this->loadModel('info_requests');  
				$solicitudes = new RequestsController;
                $report=  $solicitudes->getAllRequestsByRound($llave_ronda);
				$titulo = '';
				$imprimirEstado = 1;
				break;
		}
		
		if ($this->request->is('post')){
			//Poner aqui lo del excel
        

       /* $table = $this->loadModel('InfoRequests');
        //$rounds = $this->loadModel('Rounds');
        $roundData = $this->viewVars['roundData'];
        //$ronda_actual = $rounds->getStartActualRound();
        $ronda_actual = $roundData["start_date"];

        $reports = $table->find('all', [
            'conditions' => ['inicio' => $ronda_actual],
        ]);
*/

		switch($tipo)
		{
			case 1:
			
				//Genera el reporte de solicitudes aceptadas
				$this->createExcelApproved($report);
				break;
				
			case 2:
				//Genera el reporte de solicitudes elegibles rechazadas
				$this->createExcelReprovedAndNC($report);
				break;
				
			case 3:
				//Genera el reporte de solicitudes no elegibles
				$this->createExcelReprovedAndNC($report);
				break;
			case 4:
				//Genera el reporte de los resultados de una ronda
				$this->createExcelRoundResults($report);
				break;
		}
		
		}//Fin del post
		
		$this->set(compact('report','titulo','horas','estado','imprimirEstado'));
           
    }
    
    public function createExcelReprovedAndNC($reports){
		
		/*
		Carné | Curso | Sigla | Grupo | Ronda | Profesor |  H.A. | H.E. | Semestre |
		*/
		
        $table = $this->loadModel('InfoRequests');
        $roundData = $this->viewVars['roundData'];
        $ronda_actual = $roundData["start_date"];
        
        //Se crea archivo excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //Se ponen los títulos de las columnas
        $headerRow = array("Curso","Sigla","Grupo","Profesor","Carné","Tipo Hora");
        $sheet->fromArray([$headerRow], NULL, 'A1');
        $user= new UsersController;
        
        //Se llena el excel con solicitudes
        $cantidad = 1;
        $row = 2; 
        //Por ahora, sólo se están poniendo estos datos
        foreach ($reports as $report){
            $col = 1;
            //$sheet->setCellValueByColumnAndRow($col, $row, $report->curso);
			$sheet->setCellValueByColumnAndRow($col, $row, $report['name']);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report['curso']);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report['grupo']);
            $col++;
		    $sheet->setCellValueByColumnAndRow($col, $row, $user->getNameUser($report['id_prof']));  //temporal xd
            $col++;
			$sheet->setCellValueByColumnAndRow($col, $row, $report['carne']);
            $col++;
			$sheet->setCellValueByColumnAndRow($col, $row, $report['hour_type']);
            $row++;
            $cantidad++;
        }
        //Formato del excel
        $sheet->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()
        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->setShowGridlines(true);
        //Se establece el ancho de las celdas
        $sheet->getDefaultColumnDimension()->setWidth(15);
        //Se centra el texto
        $sheet->getStyle('A1:I'.$cantidad)
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //Cambia color de celdas de cabecera
        $sheet->getStyle('A1:F1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFF0000');
        $sheet->getPageSetup()->setPrintArea('A1:F'.$cantidad);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        
        //Descarga el archivo excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. "Reporte Historico Aceptados" .'.xls"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

	public function createExcelApproved($reports){
		
		/*
		Carné | Curso | Sigla | Grupo | Ronda | Profesor |  H.A. | H.E. | Semestre |
		*/
		
        $table = $this->loadModel('InfoRequests');
        $roundData = $this->viewVars['roundData'];
        $ronda_actual = $roundData["start_date"];
        /*$reports = $table->find('all', [
            'conditions' => ['inicio' => $ronda_actual],
        ]);*/
        
        //Se crea archivo excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //Se ponen los títulos de las columnas
        $headerRow = array("Curso","Sigla","Grupo","Profesor","Carné","Tipo Hora","Cantidad");
        $sheet->fromArray([$headerRow], NULL, 'A1');
        $user= new UsersController;
        
        //Se llena el excel con solicitudes
        $cantidad = 1;
        $row = 2; 
        //Por ahora, sólo se están poniendo estos datos
        foreach ($reports as $report){
            $col = 1;
            //$sheet->setCellValueByColumnAndRow($col, $row, $report->curso);
			$sheet->setCellValueByColumnAndRow($col, $row, $report['name']);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report['curso']);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report['grupo']);
            $col++;
		    $sheet->setCellValueByColumnAndRow($col, $row, $user->getNameUser($report['id_prof']));  //temporal xd
            $col++;
			$sheet->setCellValueByColumnAndRow($col, $row, $report['carne']);
            $col++;
			$sheet->setCellValueByColumnAndRow($col, $row, $report['hour_type']);
			$col++;
			$sheet->setCellValueByColumnAndRow($col, $row, $report['hour_ammount']);
			$col++;
            $row++;
            $cantidad++;
        }
        //Formato del excel
        $sheet->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()
        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->setShowGridlines(true);
        //Se establece el ancho de las celdas
        $sheet->getDefaultColumnDimension()->setWidth(15);
        //Se centra el texto
        $sheet->getStyle('A1:I'.$cantidad)
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //Cambia color de celdas de cabecera
        $sheet->getStyle('A1:G1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFF0000');
        $sheet->getPageSetup()->setPrintArea('A1:G'.$cantidad);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        
        //Descarga el archivo excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. "Reporte Historico Aceptados" .'.xls"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
	
	public function createExcelRoundResults($reports){
		
		/*
		Carné | Curso | Sigla | Grupo | Ronda | Profesor |  H.A. | H.E. | Semestre |
		*/
		
        $table = $this->loadModel('InfoRequests');
        $roundData = $this->viewVars['roundData'];
        $ronda_actual = $roundData["start_date"];
        /*$reports = $table->find('all', [
            'conditions' => ['inicio' => $ronda_actual],
        ]);*/
        
        //Se crea archivo excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //Se ponen los títulos de las columnas
        $headerRow = array("Curso","Sigla","Grupo","Profesor","Carné","Estado");
        $sheet->fromArray([$headerRow], NULL, 'A1');
        $user= new UsersController;
		
		$solicitudes = new RequestsController;        
        
        //Se llena el excel con solicitudes
        $cantidad = 1;
        $row = 2; 
        //Por ahora, sólo se están poniendo estos datos
        foreach ($reports as $report){
            $col = 1;
            //$sheet->setCellValueByColumnAndRow($col, $row, $report->curso);
			$sheet->setCellValueByColumnAndRow($col, $row, $report['name']);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report['curso']);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report['grupo']);
            $col++;
		    $sheet->setCellValueByColumnAndRow($col, $row, $user->getNameUser($report['id_prof']));  
            $col++;
			$sheet->setCellValueByColumnAndRow($col, $row, $report['carne']);
            $col++;
			
			switch($report['estado'])
			{
				case 'a':
					$sheet->setCellValueByColumnAndRow($col, $row, 'Aprobada');
					break;
				case 'e':
					$sheet->setCellValueByColumnAndRow($col, $row, 'Elegible');
					break;
				case 'n':
					$sheet->setCellValueByColumnAndRow($col, $row, 'No elegible');
					break;
				case 'i':
					$sheet->setCellValueByColumnAndRow($col, $row, 'Aceptado por inopia');
					break;
				case 'x':
					$sheet->setCellValueByColumnAndRow($col, $row, 'Anulada');
					break;				
				case 'r':
					$sheet->setCellValueByColumnAndRow($col, $row, 'Rechazada');
					break;					
				case 'p':
					$sheet->setCellValueByColumnAndRow($col, $row, 'Pendiente');
					break;
			}
			
			$col++;
            $row++;
            $cantidad++;
        }
        //Formato del excel
        $sheet->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()
        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->setShowGridlines(true);
        //Se establece el ancho de las celdas
        $sheet->getDefaultColumnDimension()->setWidth(15);
        //Se centra el texto
        $sheet->getStyle('A1:H'.$cantidad)
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //Cambia color de celdas de cabecera
        $sheet->getStyle('A1:G1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFF0000');
        $sheet->getPageSetup()->setPrintArea('A1:G'.$cantidad);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        
        //Descarga el archivo excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. "Reporte Historico De Resultados de Ronda" .'.xls"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

    public function createExcel($reports){
        $table = $this->loadModel('InfoRequests');
        $roundData = $this->viewVars['roundData'];
        $ronda_actual = $roundData["start_date"];
        /*$reports = $table->find('all', [
            'conditions' => ['inicio' => $ronda_actual],
        ]);*/
		

        //Se crea archivo excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //Se ponen los títulos de las columnas
        $headerRow = array("Curso","Grupo","Profesor","Carné","Semestre","Ronda");
        $sheet->fromArray([$headerRow], NULL, 'A1');
        $user= new UsersController;
        
        //Se llena el excel con solicitudes
        $cantidad = 1;
        $row = 2; 
        //Por ahora, sólo se están poniendo estos datos
        foreach ($reports as $report){
            $col = 1;
            $sheet->setCellValueByColumnAndRow($col, $row, $report->curso);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report->grupo);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $ProfessorName = $user->getNameUser($report->id_prof));
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report->carne);
            $col++;
            $sheet->setCellValueByColumnAndRow($col, $row, $report->semestre);
            $col++;
			$sheet->setCellValueByColumnAndRow($col, $row, $report->ronda);
            $row++;
            $cantidad++;
        }
        //Formato del excel
        $sheet->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()
        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->setShowGridlines(true);
        //Se establece el ancho de las celdas
        $sheet->getDefaultColumnDimension()->setWidth(15);
        //Se centra el texto
        $sheet->getStyle('A1:G'.$cantidad)
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //Cambia color de celdas de cabecera
        $sheet->getStyle('A1:G1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFF0000');
        $sheet->getPageSetup()->setPrintArea('A1:G'.$cantidad);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        
        //Descarga el archivo excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. "archivo" .'.xls"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

    public function reportsAdmin(){
        if ($this->request->is('post')){
            $data= $this->request->getData();
            $semester = $data['semester'] + 1;
            $year = $data['year'];
            $round = $data['round'] +1;

            $round_key = $this->getRoundByValues($round,$semester, $year);

			if($round_key != null)
			{		
				$round_key = $round_key[0][0];	
				
				if ($data['report_type'] == 0 )
				{		 				 
					 $parametro = $round_key . 't' . '1';				 
					 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $parametro]);
				}
				
				if ($data['report_type'] == 1 ){

					 $parametro = $round_key . 't' . '2';				 
					 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $parametro]);				}

			   if ($data['report_type'] == 2 ){

					 $parametro = $round_key . 't' . '3';				 
					 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $parametro]);		   
			   }
			   if ($data['report_type'] == 3 ){

					 $parametro = $round_key . 't' . '4';				 
					 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $parametro]);		   
			   }
	   }//Fin round_key != nulo
	   else
	   {
		   $this->Flash->error(__('Error: No se logró generar el reporte'));
	   }
           
    }
    
    $this->set(compact('report' ));
    }
    
}