<?php

namespace App\Http\Controllers\Admin;

use App\Agenda;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $agendas = Agenda::orderBy('agenda_date')->orderBy('start_time')->get();

        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.form');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->has('is_active');

        Agenda::create($data);

        return redirect()->route('admin.agendas.index')
            ->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);

        return view('admin.agendas.form', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
        $data = $this->validatedData($request);
        $data['is_active'] = $request->has('is_active');

        $agenda->update($data);

        return redirect()->route('admin.agendas.index')
            ->with('success', 'Agenda berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('admin.agendas.index')
            ->with('success', 'Agenda berhasil dihapus!');
    }

    protected function validatedData(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:5000',
            'location' => 'nullable|max:255',
            'agenda_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);
    }
}
