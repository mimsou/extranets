<?php

namespace App\Models\Enum;

class TaskType
{
    public const _IMM_ENT = '_IMM_ENT';
    public const IMM_ENT_PREP_EIMT = 'IMM_ENT_PREP_EIMT';
    public const IMM_ENT_PREP_DST = 'IMM_ENT_PREP_DST';
    public const IMM_ENT_PREP_PT = 'IMM_ENT_PREP_PT';
    public const IMM_ENT_COMPLIANCE_PREP = 'IMM_ENT_COMPLIANCE_PREP';
    public const IMM_ENT_COMMUNICATION = 'IMM_ENT_COMMUNICATION';
    public const IMM_ENT_TRADUCTION = 'IMM_ENT_TRADUCTION';
    public const IMM_ENT_ADMIN = 'IMM_ENT_ADMIN';

    public const _IMM_IND = '_IMM_IND';
    public const IMM_IND_CONSULTATION = 'IMM_IND_CONSULTATION';
    public const IMM_IND_OPEN_PERMIT = 'IMM_IND_OPEN_PERMIT';
    public const IMM_IND_STUDY_PERMIT = 'IMM_IND_STUDY_PERMIT';
    public const IMM_IND_CAQ_FAMILY = 'IMM_IND_CAQ_FAMILY';
    public const IMM_IND_CSQ = 'IMM_IND_CSQ';
    public const IMM_IND_PERM_RESIDENCE = 'IMM_IND_PERM_RESIDENCE';
    public const IMM_IND_VISA = 'IMM_IND_VISA';
    public const IMM_IND_ADMIN = 'IMM_IND_ADMIN';

    public const _IMM_GENERAL = '_IMM_GENERAL';
    public const IMM_GENERAL_DOC_MANAGEMENT = 'IMM_GENERAL_DOC_MANAGEMENT';
    public const IMM_GENERAL_ADMIN = 'IMM_GENERAL_ADMIN';

    public const _REC_INTL = '_REC_INTL';
    public const REC_INTL_DISPLAY = 'REC_INTL_DISPLAY';
    public const REC_INTL_QT = 'REC_INTL_QT';
    public const REC_INTL_INTERVIEW = 'REC_INTL_INTERVIEW';
    public const REC_INTL_MISSION = 'REC_INTL_MISSION';
    public const REC_INTL_SELECTION = 'REC_INTL_SELECTION';
    public const REC_INTL_PICKUP = 'REC_INTL_PICKUP';
    public const REC_INTL_FOLLOWUP = 'REC_INTL_FOLLOWUP';
    public const REC_INTL_ADMIN = 'REC_INTL_ADMIN';

    public const _ACC = '_ACC';
    public const ACC_TICKET_RESERVATION = 'ACC_TICKET_RESERVATION';
    public const ACC_DEPARTURE_PREP = 'ACC_DEPARTURE_PREP';
    public const ACC_HOUSING_SEARCH = 'ACC_HOUSING_SEARCH';
    public const ACC_SUPPORTED = 'ACC_SUPPORTED';
    public const ACC_HOURLY_BILLING = 'ACC_HOURLY_BILLING';

    public static function all():array{
        return [
            self::IMM_ENT_PREP_EIMT,
            self::IMM_ENT_PREP_DST,
            self::IMM_ENT_PREP_PT,
            self::IMM_ENT_COMPLIANCE_PREP,
            self::IMM_ENT_COMMUNICATION,
            self::IMM_ENT_TRADUCTION,
            self::IMM_ENT_ADMIN,

            self::IMM_IND_CONSULTATION,
            self::IMM_IND_OPEN_PERMIT,
            self::IMM_IND_STUDY_PERMIT,
            self::IMM_IND_CAQ_FAMILY,
            self::IMM_IND_CSQ,
            self::IMM_IND_PERM_RESIDENCE,
            self::IMM_IND_VISA,
            self::IMM_IND_ADMIN,

            self::IMM_GENERAL_DOC_MANAGEMENT,
            self::IMM_GENERAL_ADMIN,

            self::REC_INTL_DISPLAY,
            self::REC_INTL_QT,
            self::REC_INTL_INTERVIEW,
            self::REC_INTL_MISSION,
            self::REC_INTL_SELECTION,
            self::REC_INTL_PICKUP,
            self::REC_INTL_FOLLOWUP,
            self::REC_INTL_ADMIN,

            self::ACC_TICKET_RESERVATION,
            self::ACC_DEPARTURE_PREP,
            self::ACC_HOUSING_SEARCH,
            self::ACC_SUPPORTED,
            self::ACC_HOURLY_BILLING
        ];
    }

    public static function allByGroup():array{
        return [
                __(self::_IMM_ENT) => [
                    self::IMM_ENT_PREP_EIMT => __(self::IMM_ENT_PREP_EIMT),
                    self::IMM_ENT_PREP_DST => __(self::IMM_ENT_PREP_DST),
                    self::IMM_ENT_PREP_PT => __(self::IMM_ENT_PREP_PT),
                    self::IMM_ENT_COMPLIANCE_PREP => __(self::IMM_ENT_COMPLIANCE_PREP),
                    self::IMM_ENT_COMMUNICATION => __(self::IMM_ENT_COMMUNICATION),
                    self::IMM_ENT_TRADUCTION => __(self::IMM_ENT_TRADUCTION),
                    self::IMM_ENT_ADMIN => __(self::IMM_ENT_ADMIN),
                ],
                __(self::_IMM_IND) => [
                    self::IMM_IND_CONSULTATION => __(self::IMM_IND_CONSULTATION),
                    self::IMM_IND_OPEN_PERMIT => __(self::IMM_IND_OPEN_PERMIT),
                    self::IMM_IND_STUDY_PERMIT => __(self::IMM_IND_STUDY_PERMIT),
                    self::IMM_IND_CAQ_FAMILY => __(self::IMM_IND_CAQ_FAMILY),
                    self::IMM_IND_CSQ => __(self::IMM_IND_CSQ),
                    self::IMM_IND_PERM_RESIDENCE => __(self::IMM_IND_PERM_RESIDENCE),
                    self::IMM_IND_VISA => __(self::IMM_IND_VISA),
                    self::IMM_IND_ADMIN => __(self::IMM_IND_ADMIN)
                ],
                __(self::_IMM_GENERAL) => [
                    self::IMM_GENERAL_DOC_MANAGEMENT => __(self::IMM_GENERAL_DOC_MANAGEMENT),
                    self::IMM_GENERAL_ADMIN => __(self::IMM_GENERAL_ADMIN)
                ],
                __(self::_REC_INTL) => [
                    self::REC_INTL_DISPLAY => __(self::REC_INTL_DISPLAY),
                    self::REC_INTL_QT => __(self::REC_INTL_QT),
                    self::REC_INTL_INTERVIEW => __(self::REC_INTL_INTERVIEW),
                    self::REC_INTL_MISSION => __(self::REC_INTL_MISSION),
                    self::REC_INTL_SELECTION => __(self::REC_INTL_SELECTION),
                    self::REC_INTL_PICKUP => __(self::REC_INTL_PICKUP),
                    self::REC_INTL_FOLLOWUP => __(self::REC_INTL_FOLLOWUP),
                    self::REC_INTL_ADMIN => __(self::REC_INTL_ADMIN),
                ],
                __(self::_ACC) => [
                    self::ACC_TICKET_RESERVATION => __(self::ACC_TICKET_RESERVATION),
                    self::ACC_DEPARTURE_PREP => __(self::ACC_DEPARTURE_PREP),
                    self::ACC_HOUSING_SEARCH => __(self::ACC_HOUSING_SEARCH),
                    self::ACC_SUPPORTED => __(self::ACC_SUPPORTED),
                    self::ACC_HOURLY_BILLING => __(self::ACC_HOURLY_BILLING)
                ]
        ];
    }
/*
IMM Entreprise - Préparation EIMT
IMM Entreprise - Préparation DST
IMM Entreprise - Préparation PT
IMM Entreprise - Préparation Conformité
IMM Entreprise - Communication
IMM Entreprise - Traduction
IMM Entreprise - Admin

IMM Individu - Consultation
IMM Individu - Permis ouvert
IMM Individu - Permis d'études
IMM Individu - CAQ famille
IMM Individu - CSQ
IMM Individu - Résidence permanente
IMM Individu - Visa
IMM Individu - Admin

IMM Général - Gestion de document
IMM Général - Admin

REC INTL - Affichage
REC INTL - QT
REC INTL - Entrevue
REC INTL - Mission
REC INTL - Sélection
REC INTL - Cueillette
REC INTL - Communication / Suivi
REC INTL - Admin

ACC - réservation de billets (de l'étranger)
ACC - Préparation départ (de l'étranger)
ACC - Recherche de logement
ACC - Prise en charge
ACC - Facturation horaire
 */
}

