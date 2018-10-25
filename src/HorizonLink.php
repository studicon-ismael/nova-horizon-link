<?php

namespace MadWeb\NovaHorizonLink;

use Laravel\Nova\Tool;
use Laravel\Horizon\Horizon;

class HorizonLink extends Tool
{
    protected $label;

    const VIEW_NAME = 'nova-horizon-link::navigation';

    public function __construct(?string $label = 'Horizon Queues')
    {
        parent::__construct();

        $this->label = $label;
    }

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(self::VIEW_NAME, function ($view) {
            $view->with('label', $this->label);
        });

        $this->canSee(function ($request) {
            return Horizon::check($request);
        });
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view(self::VIEW_NAME);
    }
}
