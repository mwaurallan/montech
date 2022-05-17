<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\MessageTemplate;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class MessageTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['sentinel', 'branch']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MessageTemplate::all();

        return view('message_template.data', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('message_template.create', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = MessageTemplate::create([
            'event' => $request->event,
            'message' => $request->message,
            'status' => $request->status,

        ]);
        Flash::success(trans('general.successfully_saved'));
        return redirect('template/data');
    }


    public function show($charge)
    {

    }


    public function edit($id)
    {
        $charge = MessageTemplate::find($id);
        return view('message_template.edit', compact('charge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = MessageTemplate::find($id);
        $message->event = $request->event;
        $message->message = $request->message;
        $message->status = $request->status;
        $message->save();
        Flash::success(trans('general.successfully_saved'));
        return redirect('template/data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        MessageTemplate::destroy($id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect('template/data');
    }

}
