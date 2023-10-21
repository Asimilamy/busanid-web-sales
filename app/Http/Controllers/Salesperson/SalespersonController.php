<?php

namespace App\Http\Controllers\Salesperson;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salesperson\SubmitSalespersonRequest;
use App\Models\Salesperson;
use App\Models\User;
use Inertia\Inertia;

class SalespersonController extends Controller
{
    public function create(): \Inertia\Response
    {
        return Inertia::render('Salespeople/Create');
    }

    public function edit(Salesperson $salesperson): \Inertia\Response
    {
        return Inertia::render('Salespeople/Edit', [
            'salesperson' => $salesperson,
            'user' => $salesperson->user
        ]);
    }

    public function submit(SubmitSalespersonRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $action = $request->has('id') ? 'update' : 'create';
        $salesperson = ! $request->has('id')
            ? new Salesperson()
            : Salesperson::find($request->id);
        $user = ! $request->has('id')
            ? new User()
            : $salesperson->user;
        $user->fill($request->except('id'));
        $user->save();
        $salesperson->fill($request->only('id'));
        $salesperson->save();
        sleep(1);

        return redirect(route('salespeople'))
            ->with('message', 'Successfully ' . $action . ' salesperson!');
    }

    public function destroy(Salesperson $salesperson): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $salesperson->delete();
        sleep(1);

        return redirect(route('salespeople'))
            ->with('message', 'Salesperson deleted successfully!');
    }
}
