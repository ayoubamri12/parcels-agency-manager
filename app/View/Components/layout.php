<?php

namespace App\View\Components;

use App\Models\Parcel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;





class layout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $rt = Parcel::where('created_at', '<=', now()->subDays(3))->where('status','!=','Livré') ->whereNull('returned')->get();
        return view('components.layout',compact('rt'));
    }
} 
