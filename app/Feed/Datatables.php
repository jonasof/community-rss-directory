<?php

namespace App\Feed;

use Illuminate\Http\Request;
use App\Models\{Feed};

class Datatables
{
    public function getHomepage(Request $request)
    {
        return $this->getBase($request);
    }

    public function getExport(Request $request) {
        return $this->getBase($request)
            ->skipPaging();
    }

    private function getBase(Request $request) {
        return datatables()
            ->of(Feed::withTags($request->tag))
            ->orderColumn('status', function ($query, $order) {
                $query->orderByJoin('lastStatus.online', $order);
            });
    }
}