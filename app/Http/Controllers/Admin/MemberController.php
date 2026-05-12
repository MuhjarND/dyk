<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $members = Member::orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $statusOptions = Member::statusOptions();

        return view('admin.members.form', compact('statusOptions'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request->file('photo'));
        }

        Member::create($data);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $statusOptions = Member::statusOptions();

        return view('admin.members.form', compact('member', 'statusOptions'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($member);
            $data['photo'] = $this->storePhoto($request->file('photo'));
        }

        $member->update($data);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $this->deletePhoto($member);
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }

    protected function validatedData(Request $request)
    {
        return $request->validate([
            'name' => 'required|max:150',
            'position' => 'required|max:150',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'membership_status' => 'required|in:anggota,istimewa,luar_biasa',
            'sort_order' => 'nullable|integer|min:0',
            'quote' => 'nullable|max:500',
        ]);
    }

    protected function storePhoto($file)
    {
        $directory = public_path('uploads/members');

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = 'member_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'members/' . $filename;
    }

    protected function deletePhoto(Member $member)
    {
        if ($member->photo && file_exists(public_path('uploads/' . $member->photo))) {
            unlink(public_path('uploads/' . $member->photo));
        }
    }
}
