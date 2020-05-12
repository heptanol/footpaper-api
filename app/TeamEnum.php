<?php

namespace App;


class TeamEnum
{
    const Olympique_de_Marseille = 516;
    const Olympique_Lyonnais = 523;
    const Lille_OSC = 521;
    const OGC_Nice = 522;
    const AS_Monaco_FC = 548;
    const Paris_Saint_Germain_FC = 524;

    const Real_Madrid_CF = 86;
    const Valencia_CF = 95;
    const Sevilla_FC = 559;
    const Athletic_Club = 77;
    const Club_Atletico_de_Madrid = 78;
    const FC_Barcelona = 81;

    const Manchester_City_FC = 65;
    const Liverpool_FC = 64;
    const Chelsea_FC = 61;
    const Tottenham_Hotspur_FC = 73;
    const Arsenal_FC = 57;
    const Manchester_United_FC = 66;
    const Leicester_City_FC = 338;

    const Atalanta_BC = 102;
    const Juventus_FC = 109;
    const AC_Milan = 98;
    const SS_Lazio = 110;
    const FC_Internazionale_Milano = 108;
    const SSC_Napoli = 113;
    const AS_Roma = 100;

    const BV_Borussia_09_Dortmund = 4;
    const FC_Bayern_Munchen = 5;
    const RB_Leipzig = 721;

    public static function getImportantTeams()
    {
        return [
            self::Olympique_de_Marseille,
            self::Olympique_Lyonnais,
            self::Lille_OSC,
            self::OGC_Nice,
            self::AS_Monaco_FC,
            self::Paris_Saint_Germain_FC,
            self::Real_Madrid_CF,
            self::Valencia_CF,
            self::Sevilla_FC,
            self::Athletic_Club,
            self::Club_Atletico_de_Madrid,
            self::FC_Barcelona,
            self::Manchester_City_FC,
            self::Liverpool_FC,
            self::Chelsea_FC,
            self::Tottenham_Hotspur_FC,
            self::Arsenal_FC,
            self::Manchester_United_FC,
            self::Leicester_City_FC,
            self::Atalanta_BC,
            self::Juventus_FC,
            self::AC_Milan,
            self::SS_Lazio,
            self::FC_Internazionale_Milano,
            self::SSC_Napoli,
            self::AS_Roma,
            self::BV_Borussia_09_Dortmund,
            self::FC_Bayern_Munchen,
            self::RB_Leipzig,
        ];
    }

}