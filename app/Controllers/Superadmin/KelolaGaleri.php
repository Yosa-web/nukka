<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaGaleri extends BaseController
{
    public function index()
    {
        $galeriModel = new GaleriModel();
        $data['galeris'] = $galeriModel->findAll();

        return view('super_admin/galeri/index', $data);
    }

    public function create()
    {
        return view('super_admin/galeri/create');
    }

    public function store()
    {
        $galeriModel = new GaleriModel();
        $logModel = new LogAktivitasModel();

        $data = [
            'judul'        => $this->request->getPost('judul'),
            'id_user'      => $this->request->getPost('id_user'),
            'url'          => $this->request->getPost('url'),
            'tipe'         => $this->request->getPost('tipe'),
            'uploaded_by'  => auth()->user()->id,
            'uploaded_at'  => date('Y-m-d H:i:s'),
        ];

        if ($galeriModel->save($data)) {
            // Log activity here
            return redirect()->to('/super_admin/galeri')->with('success', 'Galeri berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }

    public function edit($id)
    {
        $galeriModel = new GaleriModel();
        $data['galeri'] = $galeriModel->find($id);
        return view('super_admin/galeri/edit', $data);
    }

    public function update($id)
    {
        $galeriModel = new GaleriModel();

        $data = [
            'judul'        => $this->request->getPost('judul'),
            'id_user'      => $this->request->getPost('id_user'),
            'url'          => $this->request->getPost('url'),
            'tipe'         => $this->request->getPost('tipe'),
            'uploaded_by'  => auth()->user()->id,
            'uploaded_at'  => date('Y-m-d H:i:s'),
        ];

        if ($galeriModel->update($id, $data)) {
            return redirect()->to('/super_admin/galeri')->with('success', 'Galeri berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }

    public function delete($id)
    {
        $galeriModel = new GaleriModel();
        $galeriModel->delete($id);
        return redirect()->to('/super_admin/galeri')->with('success', 'Galeri berhasil dihapus.');
    }
}
