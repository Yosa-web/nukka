<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\JenisInovasiModel;
use App\Models\UserModel;

/**
 * Class BaseController
 */
abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $jenis_inovasi; // Deklarasikan properti

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load model jenis_inovasi
        $jenisInovasiModel = new JenisInovasiModel();
        $this->jenis_inovasi = $jenisInovasiModel->findAll();


    }

    public function renderView($view, $data = [])
    {
        $data['jenis_inovasi'] = $this->jenis_inovasi; // Tambahkan data jenis_inovasi ke setiap view
        return view($view, $data);
    }

    /**
     * Redirect user based on their group
     *
     * @return void
     */


    
}
