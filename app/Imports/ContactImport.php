<?php

namespace App\Imports;

use App\Models\Employeur;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if($row["est_utilisateur"] || is_null($row["societe"])) continue;

            // On check si l'entreprise existe déjà
            $e = Employeur::where('nom', '=', $row["societe"])->first();

            if(is_null($e)){
                // we create the cie if does not exist
                $e = new Employeur;
                $e->nom = $row["societe"];
                $e->adresse = $row["adresse_1"];
                $e->adresse_2 = $row["adresse_2"];
                $e->ville = $row["ville"];
                $province = null;
                if(!empty($row["province"]) && $row["province"][0] == 'Q') $province = 'QC';
                if(!empty($row["province"]) && $row["province"][0] == 'O') $province = 'ON';
                $e->province = $province;
                $e->pays_id = 16;
                $e->zip = $row["code_postal"];
            }

            $first_name = null;
            $last_name = null;
            $contact_name = $row["contact"];
            if(!empty($contact_name)){
                $names = explode(' ', $contact_name);
                $first_name = $names[0];
                unset($names[0]);
                if(!empty($names)){
                    $last_name = implode(' ', $names);
                }
            }

            if(empty($e->contact_prenom)){
                $e->contact_nom = $last_name;
                $e->contact_prenom = $first_name;
                $e->contact_titre = $row["titre"];
                $e->contact_email = $row["e_mail"];
                $e->contact_phone = $row["telephone"];
                $e->contact_ext = (empty($row["poste"]))?null:$row["poste"];

            }elseif(empty($e->secondary_contact_prenom)){
                $e->has_secondary_contact = 'yes';
                $e->secondary_contact_nom = $last_name;
                $e->secondary_contact_prenom = $first_name;
                $e->secondary_contact_titre = $row["titre"];
                $e->secondary_contact_email = $row["e_mail"];
                $e->secondary_contact_phone = $row["telephone"];
                $e->secondary_contact_ext = (empty($row["poste"]))?null:$row["poste"];

            }elseif(empty($e->third_contact_prenom)){
                $e->has_third_contact = 'yes';
                $e->third_contact_nom = $last_name;
                $e->third_contact_prenom = $first_name;
                $e->third_contact_titre = $row["titre"];
                $e->third_contact_email = $row["e_mail"];
                $e->third_contact_phone = $row["telephone"];
                $e->third_contact_ext = (empty($row["poste"]))?null:$row["poste"];
            }

            $e->save();

            // dd($e);

            // Employeur::create([
            //     'name' => $row[0],
            // ]);
        }
    }
}
