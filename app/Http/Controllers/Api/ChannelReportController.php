<?php

namespace App\Http\Controllers\Api;

use App\Entities\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelReportController extends Controller
{

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $author = Author::firstOrNew(['id' => $request->channel_id]);

        $author->sendReport();

        return ['type' => $author->type()];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $author = Author::firstOrNew(['id' => $request->channel_id]);

        $author->updateReports(-1);

        return ['type' => $author->type()];
    }
}
