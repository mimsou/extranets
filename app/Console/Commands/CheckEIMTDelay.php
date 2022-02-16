<?php

namespace App\Console\Commands;

use App\Models\Demande;
use Illuminate\Console\Command;

class CheckEIMTDelay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eimt:avgdelay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the average delay for EIMT';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Calcul de la moyenne');

        $all_demandes_with_eimt_envoi = Demande::whereNotNull('eimt_date_envoi')->get();

        $tot_demandes = 0;
        $tot_jours = 0;

        foreach ($all_demandes_with_eimt_envoi as $d) {
            $p = $d->projet;
            $e = $d->employeur;
            if(is_null($p) || 
                is_null($p->date_selection) || 
                (is_null($e)) || 
                (is_null($e->regroupement)) || 
                !str_contains($p->statut, 'eimt')) continue;

            if(!str_contains(strtolower($e->regroupement->title), 'ccaq')) continue;

            $date_selection = \Carbon\Carbon::parse($p->date_selection);
            $date_eimt = \Carbon\Carbon::parse($d->eimt_date_envoi);

            $days_inbetween = $date_selection->diff($date_eimt)->days;
            
            if($days_inbetween > 300) continue;

            $tot_jours += $days_inbetween;
            $tot_demandes++;

            

            $this->info('Projet#: '.$p->numero.' - - Assoc:'.$e->regroupement->title.' - - NB Jours:'.$days_inbetween.' - - NB Demande: '.$tot_demandes.' - - MOY:'. $tot_jours / $tot_demandes);
         
        }
    }
}
