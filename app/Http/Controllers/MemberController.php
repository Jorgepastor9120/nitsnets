<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index()
    {
        return view('members.index', [
            'members' => Member::orderBy('id', 'desc')
                                ->paginate(5)
        ]);
    }

    public function create(Member $member)
    {
        return view('members.member_create', [
            'member' => $member
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:members,email',
        ]);
        
        $createMember = Member::create(
            [
                'name' => $request->name,
                'email' => $request->email,
            ]);

        return view('members.member_edit', [
                'member' => $createMember,
                'btnNewMember' => true
            ]);
    }

    public function show(Member $member)
    {
        //En desuso
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('members.member_edit', [
            'member' => $member
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                 Rule::unique('members', 'email')->ignore($member->id)
             ]
        ]);

        $member->update(
            [
                'name' => $request->name,
                'email' => $request->email
            ]);

        return view('members.member_edit', [
            'member' => $member
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return back();
    }
}
