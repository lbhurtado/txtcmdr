<?php

use Illuminate\Database\Seeder;
use App\Missive\Domain\Repositories\ContactRepository;

class ContactSeeder extends Seeder
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->delete();

        foreach ($this->getContacts() as $data) {
            $this->contactRepository->create([
                'mobile' => $data[0],
                'handle' => $data[1],
                'extra_attributes' => json_decode($data[2]),
            ]);
        }
    }

    protected function getContacts()
    {
        return array_merge($this->getSystemData(), config('txtcmdr.data.load.test_data', false) ? $this->getTestData() : []);
    }

    protected function getSystemData()
    {
        return [
            [+639173011987,'Lester Hurtado','{"token": "HjvtzaRUyDDUANLR3bvcpqLeWQG_WpXsq7PJaxArctI", "telerivet_id": "CT952e32b42f0a515f"}'],
            [+639178915975,'Levi Baligod','{"token": "sGqcYEYY2Y3aWrYEhaMgSMlOQKSraa2hFMLuRVTluwY"}'],
            [+639166033598, 'Chris Suguitan','{"token": "wYe8ubCzFWZWKEZOXQ6rozwV9h8h_Hj47v3D4fOezKg"}'],
            [+639177210752, 'Francesca Hurtado','{"token": "VE7tjY5QRGViysms339jNv_Dkq9tbOLQPX5GbSz0zOc"}'],
            [+639399236237, 'Sofia Hurtado','{"token": "bVVknsRfb0Rw2HF_a4SVMZ-zBuJb5AI2U0K-aQPXKMs"}'],
            [+639175180722, 'Apple Hurtado','{"token": "jvZpwhjqaqvr3oE_ar4m7se6cg2LfmEHjuHLTOaCqls"}'],
            [+639175793359, 'Joan Cruz','{"token": "JBc5yuMukLuUt20JPSgrKK_Ha28VOz1zD1EGOmsknPY"}'],

        ];
    }

    protected function getTestData()
    {
        return [
            [+639653341244,NULL,'{"token": "E1INzGGe8FJSmbfmrTvPX0ab8LXbKsCu6sUV8CquBNU"}'],
            [+639061924348,'MARLON CORBES','{"token": "f2X5BU63e7cOWUdOoQUPEZgOZF6Ibx6IAjRQCseLmsM"}'],
            [+639269980456,'EDWIN VICENTE V. TOLIBAS','{"token": "W0ZvwjEoOBVr1uAIPvjjQwmhwOCTi-rGZ5rFwh01p48"}'],
            [+639363360780,NULL,'{"token": "1oNT4HBFKMwv20Xtb-QhRBtO2t1yPPTjkftOUFt2e_0"}'],
            [+639274472845,'NOOKIE OMANA','{"token": "v9RBTnxKLr4Xzgb2CB9i_5nj1MtWMLbWYK7XKJDOPrU"}'],
            [+639161580958,'BENJAMIN GONZAGA','{"token": "WILMXe7Ns4ovy8wLSRqsG-VUBEm9n2FfEFYbT8qOu6k"}'],
            [+639971491382,'LILITA OMANA','{"token": "faIFdPWDgbXoZbIqfkrwj_hwvxXKkUw4eCzZaZbsG6U"}'],
            [+639274920365,NULL,'{"token": "2B3JigJNrv_h3Vg4-6BfFop672x2ExtyQ8MtPFoBnGM"}'],
            [+639356901323,NULL,'{"token": "iZGeIRKCmvtsXCdKt7_sJBqjtghmDI4-bdRQfu_n-l4"}'],
            [+639168682028,'GIOVANNI VARRON','{"token": "yK1Yeh7kKjUPPSGCuj8jYM7HL1i013yampX_HlQltic"}'],
            [+639274046128,'EARL NUNEZ','{"token": "eYhglmEHnwhVnyZV9E2p4mbR7UWLH9IA64dp8eNhG2E"}'],
            [+639359471914,'REGALADO H. DECENA, JR.','{"token": "-J_xPSqZ3P4qoaxBpn8mXmwjlje30AuNBEyz5OJvOrE"}'],
            [+639977745895,'JANETH CORBES','{"token": "fViR2On2i1yv1X0RMm-BaKuHYsc0yxGcuhw0KsU6T2w"}'],
            [+639276630603,'OLIVER CUA','{"token": "MBfgs0S1MwZKTt7qQkqJh7P39Lcdwns3iEbNiWcjDxY"}'],
            [+639752118127,NULL,'{"token": "xexKU4P7tos1i_hYcaG71VIYTTaSbnwLG1fAtzDvuL0"}'],
            [+639557190097,NULL,'{"token": "MFXhaGcElHingcbr-0_d7v1jotSl6L0_ydNCnwGiCkA"}'],
            [+639277571930,'NOELBTOLIBAS','{"token": "nJQZIHx9jE_JR-4e1QkYZ1UwK7D1cLbphktMSeTfU1E", "telerivet_id": "CT8c67798001144f4e"}'],
            [+639058352725,'John Paul Bulawan','{"token": "PLSWv5DBwFdvRyEAFhwVQKJ02UDDqHbiThrNG2Uewp4", "telerivet_id": "CT8e34ba1c3bd1811c"}'],
            [+639173224217,'Irma Barbara Guibone','{"token": "wUXgq2YBZubvY1I3zy6qHHvx69H1p6CVWinQM1UkZQc", "telerivet_id": "CT92b16cae2e533207"}'],
            [+639362945876,'Susanalyn Basmayor','{"token": "wOrbZJKZhevTFTnyXrHycAZShbgIAO0RVTNq7eLvL4g", "telerivet_id": "CT957b2feb116a3bc6"}'],
            [+639551302078,'MA.RICARDA NOPAL','{"token": "PJ-UChkF8IVrv2O1la3i4aqoJcZ-w6LKpxQW6hFlGGM", "telerivet_id": "CT2d1ddaa3be2f9c22"}'],
            [+639979280256,'{ LEVI BALOGOD }','{"token": "k9dhNH46-47m96Npc5w3qxrVQE9FFqv0pF2khQOX_FY"}'],
            [+639277714423,'DIANA  MANAGBANAG','{"token": "gwSLMcfu_hImoMavouHViI9oVLalCJKvD9nxFl9uYzI", "telerivet_id": "CT73271c60947a2838"}'],
            [+639360878490,'RONALDO LAURINO','{"token": "6r_9_8wdjAgF7iboJXh0Gqa45qc014ppd5yNNOJ675g", "telerivet_id": "CT4662306b7103f25b"}'],
            [+639261033340,'VILMA PATOLILIC','{"token": "iZwTJYoosjfnTEDwz28bk5y72DO9qjA1inNGYM6EqxE"}'],
            [+639774595373,'Abigail Picatoste','{"token": "QlmbzDPBXG-wWo_LOKB3erCB45J7dDosktvEEl_EfFg"}'],
            [+639650989282,'reydyn regulacion','{"token": "RgYY2JRSCgtGuB6AzoWgl1N9VNJziRj-I2Nm6vZbCPc", "telerivet_id": "CTf0774e79f093cb6a"}'],
            [+639956977093,'NARCISO JR. PAEL','{"token": "3Xiz3ihZ_nBQjPKp_QBxFHt_kZ2q9MSR3HqeeYlvQyk", "telerivet_id": "CT8b6669804d93bbd9"}'],
            [+639362112401,'NENIA MORENO','{"token": "jx6bx3ZW46jf4nMvQvad-_z_6bOzmv1y2wo0uOwFwzA", "telerivet_id": "CT78d75f5ff7ce8b46"}'],
            [+639362385650,'antonio romanillos jr.','{"token": "HuNkSl5FhZ7tvhCxF2KV-1iqzq-zL7ZEqPw88VGX_Ts", "telerivet_id": "CT6d2c6efe5bb987e2"}'],
            [+639759751075,'JOY NAPOLES','{"token": "HlcYUmAcrF92e6qtOQ0aic9Rjp7ZDxLlSxCfrvyDdAQ", "telerivet_id": "CT7f8946563b570d4d"}'],
            [+639264466534,NULL,'{"token": "BqzhAZouQcJeNz5n5InV2pRRe0MATOiT-dn1CwQwK_Y", "telerivet_id": "CTd787c6016ca7d1ed"}'],
            [+639169890554,'BENITO BERAY','{"token": "1RzsvQ2wlhehAiYF6gCm28os3qHS3s5UpSu5E_IKSZs"}'],
            [+639978392034,NULL,'{"token": "FVEJQbXF41XwJ5m5oLInEMCwyB-xnOsnN0nVUGXIGmQ", "telerivet_id": "CTe42fbb54be823374"}'],
            [+639268429411,'CERNIE VALENZONA','{"token": "6YTzE3xPnlQYKAMdMIOxmhgsndwMl36uIwlSOpEAsyg", "telerivet_id": "CT1d72ee4706d75ed0"}'],
            [+639356646356,NULL,'{"token": "b92V7ZrKVOUN45TyKo9uIpKNTC6Yu1mQnbC_PVmsILg"}'],
            [+639557531869,NULL,'{"token": "4SQHR8H7zN_mtQ0sthAspc6-agORByJTKxg2ie-32yE"}'],
            [+639275320714,'MARKJOHN TITO','{"token": "WvWqADHMh_QlHRX_w3YmXFOz2zT_zRHEN60MsYF5sEU", "telerivet_id": "CT3e77ad5b4c94a96d"}'],
            [+639058830085,'AZRI GURIL','{"token": "cxLAmXzKf6XXrriyjUTs_vvmcdQ3fUS3j53Ykln3dlY", "telerivet_id": "CTa929aff274d792b5"}'],
            [+639276992665,'IMELDA A.MENDEZ','{"token": "FLC2K14x8mrLc16_NvJ2HcZASsVAcCL7tRMxII_Whhs", "telerivet_id": "CTdf6142beb29d9003"}'],
            [+639754642693,NULL,'{"token": "HydB_75YLl3kSyTATeh_D84YpsX6SS4dcnL51sE6YAg", "telerivet_id": "CT2df4ca69f542489f"}'],
            [+639263507133,NULL,'{"token": "Dd3CTwdTgdLa9PFHookSgi34IbVkYABF43_FAAhqFDc", "telerivet_id": "CT89ceee9cb093506f"}'],
            [+639352379764,'Annaliza llagas','{"token": "NFXaYvnrsGk19LJzgIFBRCFlA8HwQBNDA9Tng67ZLsQ", "telerivet_id": "CTa18653c3684b080e"}'],
            [+639363266622,'MARIANNE AUSAN','{"token": "OcFkhKCtjkPXNJ3pxITYhLeffJQihMrOs13ztvWN1y0", "telerivet_id": "CTda5b3d970fcc90c7"}'],
            [+639265873729,NULL,'{"token": "JxWsyXMoTrU65stLMQ6aOgGHqdVOJnvFjAmJAZv0BjY", "telerivet_id": "CT7f283ea00e6dc8d5"}'],
            [+639263500694,'SABINA HORIUCHI','{"token": "PiaKRztLzrN5zKfxmDqaZXCoo4BmjOUSIk5SjSNp08Y"}'],
            [+639550829903,' DYESEBEL BANDALAN','{"token": "tO1iIYfk6E8xuhuzOxwquaC7qUvwErS954Q7ZfL0vZ4", "telerivet_id": "CT2426e6aae4c01c9d"}'],
            [+639553962556,'perla cerna','{"token": "j4qnqgdhSXsft4bgwamq_td06iTFmVF8UDMkz43Brhc", "telerivet_id": "CT6747c1fc23a5d787"}'],
            [+639551462325,NULL,'{"token": "d8A7w23lHZoKEh9rUsTC4JSwixKAkyj4DYPIw4HWF1o"}'],
            [+639268014551,'NEIL VILLACORTE','{"token": "3ow-qH9P-C2exkBphqNUDLqyUBDZ78y0_eOn5QOorco", "telerivet_id": "CT8383b5696bfb60dd"}'],
            [+639361136062,NULL,'{"token": "4hq77L8VUkj6diptXXb3jfNj8LptYgl-LA9fnp6l_LU"}'],
            [+639566532830,'DINGDING MEREDORES','{"token": "9hR_tCVaReJxvnNnlZ7HhaXLfN-xczYXMqsPtDzk_D4"}'],
            [+639264923820,NULL,'{"token": "jLIJvegY8zXpRlSbTqHj5pT94q3v3RmQbhwIGeOag2A", "telerivet_id": "CT519e1305d817c4a2"}'],
            [+639165775285,'ANABEL M. MARASIGAN','{"token": "A63ubtd3IR_R9rIhzo3_m8DEXJgKMgCzS2J0-jGPWCI"}'],
            [+639351467961,'RICARDO MORALES','{"token": "4EushtmSMJR5Z_LWJB3TCq6OAfQ7qQlIBoSyLhaIGvY", "telerivet_id": "CT5a91fe30e8048c68"}'],
            [+639356246100,NULL,'{"token": "W3C65lpaRYm1GS8E7aHn9C8LItMHfgXR1NBZOgDDNAY"}'],
            [+639366113234,NULL,'{"token": "eq9SECTAOUkSbANY6psGfgvbeR9r_8XG6fcQGxuFces"}'],
            [+639559775550,NULL,'{"token": "7fh9KPj_osvVQZn7dcl784eba58rzObPrVXuvJIpDsw"}'],
            [+639655707948,'belma acilo','{"token": "yIaDpB5_4NDXowzmXLGtx1vja6QnNcNCyOeXVFYa8qI", "telerivet_id": "CTedc7de5056409e2e"}'],
            [+639758185659,'ROLAND A SILVA JR.','{"token": "0t_xXzuQ7lEEU83qCcZzCTu0jQdMgKXWGk-0zh3fprQ", "telerivet_id": "CT693cf6e3cfa0a4f9"}'],
            [+639364940655,'Sofia Bulawan','{"token": "LpFwMdrfyziQ1M_9BRfX0UxFjV9CJDKsT7-8sWpFGLk"}'],
            [+639368313431,'NIMFA BAGARINAO','{"token": "tBmp5MXgmS8k5cVBkAxhkO4sCQWaYoccyn8RiWDDmKM"}'],
            [+639363156105,NULL,'{"token": "HUq1VDeSf8AqfU2IPJBhU0tB8GSy6jKrX68-bNA2Sm4", "telerivet_id": "CT48bfa4a7b2004eae"}'],
            [+639362947978,'ALLAN S. MANAGBANAG','{"token": "kfQS-z6LwiLdsayB9sOiOso0Hd2Z3ZzSJ9TC3caf6vI", "telerivet_id": "CT8c4c47eb0940062e"}'],
            [+639675048920,NULL,'{"token": "weLWsa-75Or7LrPqoFeuClpRAEPUPVTEmSv_ORPq0zQ"}'],
            [+639357439025,NULL,'{"token": "iHjyoWaz3lB6YmkraONC0WVWT8wWHER6YGC-AWUP2_w"}'],
            [+639651779212,NULL,'{"token": "EgIlLKRGM04Dv0i4abpo0Wc8i3bPNsh-Y9BbiJUCPF0"}'],
            [+639751374430,NULL,'{"token": "e4A9bwO2meGrt4_2qe5LkbS6IB8Ona1vJ-wKUuz9FuI"}'],
            [+639264038122,'ERICK DALDE','{"token": "3DjtedVJjRyHaaI5dHg3BZaEDXp0rcn_roZ3Rnqgl5A"}'],
            [+639169109169,NULL,'{"token": "d1ZEMZIC2CMHuAU0NaEl4E18Ac3boT12hv2ClBXuX2s"}'],
            [+639061007165,'RIZALDE PALERMO BARANGAY IGANG','{"token": "HTHrAQAuslQwptKsJlR3U3YpEDzBsZ3ojpqrZZsxxi0"}'],
            [+639098004795,'ROBERTO DELA CERNA JR',NULL],
            [+639051964214,NULL,'{"token": "P0zMiLem57Tmq77vtrTY7tDQe3yD1AJW8iU6pWt4zhI"}'],
            [+639362947436,NULL,'{"token": "C9HeBTLMAG8yIS8sl0Ah9KKIdGLVVKKwQUbhsZN79Ys"}'],
            [+639651340024,NULL,'{"token": "zZ1Ym1Euebe9y-vVnBZeJpxr5PzgXz2cDcWPGbJ-w0Y"}'],
            [+639161580965,NULL,'{"token": "OSMQwAg5zOwPKNgIezFe3s2ZKqoo4IdglVU0S0YJjmk"}'],
            [+639978804005,'(RAPAS)(EILYN)','{"token": "ZGtneFe_2L-UmZnVmv2g4vStWnhiCWnqyu8YiVXz6ds"}'],
            [+639975065812,'FIDELINA VEGA','{"token": "rLsmLQK6cr3treHdIY-JFVFQSzK8LsUN3RqILfDkCjM"}'],
            [+639153968242,NULL,'{"token": "PggGwXhYChrQuhKI3b3cZOw5t4n0oOUXfiroZX5-JqY"}'],
            [+639175834152,NULL,'{"token": "4SQxm9icybR3LPzG4Rx-CEsa_hRsN5uRHSVdFqS5pkE"}'],
        ];
    }
    protected function locker()
    {
        //        $lester = tap(Contact::create(['mobile' => '+639173011987', 'handle' => 'Lester Hurtado']), function ($contact) {
//        	$contact->token = 'HjvtzaRUyDDUANLR3bvcpqLeWQG_WpXsq7PJaxArctI';
//            $contact->save();
//        });
//        $levi = tap(Contact::create(['mobile' => '+639178915975', 'handle' => 'Levi Baligod']), function ($contact) {
//            $contact->token = 'sGqcYEYY2Y3aWrYEhaMgSMlOQKSraa2hFMLuRVTluwY';
//            $contact->save();
//        });
//        $obbie = tap(Contact::create(['mobile' => '+639166033598', 'handle' => 'Chris Suguitan']), function ($contact) {
//            $contact->token = 'wYe8ubCzFWZWKEZOXQ6rozwV9h8h_Hj47v3D4fOezKg';
//            $contact->save();
//        });
//        $francesca = tap(Contact::create(['mobile' => '+639177210752', 'handle' => 'Francesca Hurtado'], $lester), function ($contact) {
//            $contact->token = 'VE7tjY5QRGViysms339jNv_Dkq9tbOLQPX5GbSz0zOc';
//            $contact->save();
//        });
//        $sofia = tap(Contact::create(['mobile' => '+639399236237', 'handle' => 'Sofia Hurtado'], $lester), function ($contact) {
//            $contact->token = 'bVVknsRfb0Rw2HF_a4SVMZ-zBuJb5AI2U0K-aQPXKMs';
//            $contact->save();
//        });
//        $apple = tap(Contact::create(['mobile' => '+639175180722', 'handle' => 'Apple Hurtado'], $lester), function ($contact) {
//            $contact->token = 'jvZpwhjqaqvr3oE_ar4m7se6cg2LfmEHjuHLTOaCqls';
//            $contact->save();
//        })->save();
//
//        $joan = tap(Contact::create(['mobile' => '+639175793359', 'handle' => 'Joan Cruz']), function ($contact) {
//            $contact->token = 'JBc5yuMukLuUt20JPSgrKK_Ha28VOz1zD1EGOmsknPY';
//            $contact->save();
//        });
//        $smart = tap(Contact::create(['mobile' => '+639081877788', 'handle' => 'Smart Subscriber']), function ($contact) {
////            $contact->token = 'JBc5yuMukLuUt20JPSgrKK_Ha28VOz1zD1EGOmsknPY';
////            $contact->save();
//        });
//
//        $obbie->appendToNode($lester)->save();
//        $levi->appendToNode($obbie)->save();
//        $joan->appendToNode($obbie)->save();
    }
}
