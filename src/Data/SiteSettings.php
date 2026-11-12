<?php
namespace Domus\Data;
final class SiteSettings {
    public static function fields(): array {
        return [
            'layout'=>['Aspetto','Versione della home','select','vicina',['base'=>'Base · approvata','obliqua'=>'Tagli di luce','vicina'=>'Vicina, ogni giorno']],
            'site_name'=>['Identità','Nome pubblico','text','Domus Medica'],
            'seo_home_title'=>['SEO','Titolo homepage (vuoto: automatico)','text',''],
            'seo_home_description'=>['SEO','Descrizione homepage (vuoto: automatica)','textarea',''],
            'phone'=>['Contatti','Telefono','text','06 23 11 843'],
            'email'=>['Contatti','Email','email','info@analisidomusmedica.it'],
            'facebook'=>['Contatti','Facebook','url','https://www.facebook.com/Domus-medica-1693121750953693/'],
            'address'=>['Contatti','Indirizzo','text','Via dei Castani, 170'],
            'postcode'=>['Contatti','CAP','text','00172'],
            'city'=>['Contatti','Città / quartiere','text','Roma · Centocelle'],
            'company'=>['Contatti','Ragione sociale','text','Domus Medica Srl'],
            'vat'=>['Contatti','Partita IVA','text','01315941003'],
            'reports_url'=>['Contatti','Referti online','url','https://www.refonline.it/'],
            'hero_title'=>['Apertura','Titolo','textarea',"Analisi cliniche,\nvicino a te."],
            'hero_description'=>['Apertura','Testo','textarea','Il laboratorio a Roma Centocelle. Consulta i pacchetti, gli orari dei prelievi e i contatti per organizzare la tua visita.'],
            'hero_button'=>['Apertura','Pulsante pacchetti','text','Scopri i pacchetti'],
            'desk_title'=>['Apertura','Titolo informazioni rapide (Tagli di luce)','text','Per la tua visita.'],
            'call_label'=>['Apertura','Pulsante telefono','text','Chiama il laboratorio'],
            'accreditation'=>['Apertura','Nota accreditamento','text','Laboratorio convenzionato con il SSN'],
            'packages_title'=>['Pacchetti','Titolo sezione','text','Pacchetti di analisi.'],
            'packages_intro'=>['Pacchetti','Introduzione','textarea','Esplora i nostri pacchetti di analisi. Esami, informazioni e costi: tutto chiaro, prima ancora di arrivare in laboratorio.'],
            'packages_note'=>['Pacchetti','Nota prezzi','textarea','Le tariffe riportate nelle schede del sito sono da confermare con il laboratorio.'],
            'services_title'=>['Altri servizi','Titolo sezione','text','Altri servizi.'],
            'services_intro'=>['Altri servizi','Introduzione','textarea','Informazioni e contatti per gli altri servizi del laboratorio.'],
            'visit_title'=>['La tua visita','Titolo sezione','textarea',"La tua visita,\nsenza incertezze."],
            'step1_title'=>['La tua visita','Passo 1: titolo','text','Scegli e informati'],
            'step1_text'=>['La tua visita','Passo 1: testo','textarea','Esplora i pacchetti o chiama la segreteria per informazioni sugli esami che devi effettuare.'],
            'step2_title'=>['La tua visita','Passo 2: titolo','text','Prepara la tua visita'],
            'step2_text'=>['La tua visita','Passo 2: testo','textarea','Verifica gli orari e chiedi le indicazioni di preparazione specifiche per le tue analisi.'],
            'step3_title'=>['La tua visita','Passo 3: titolo','text','Ritira il tuo referto'],
            'step3_text'=>['La tua visita','Passo 3: testo','textarea','Concorda le modalità di ritiro con il laboratorio o accedi al servizio di refertazione online.'],
            'hours_title'=>['Orari','Titolo sezione','text','Orari del laboratorio.'],
            'hours_intro'=>['Orari','Introduzione','textarea','Prelievi e ritiro dei referti: consulta gli orari prima di venire.'],
            'faq_title'=>['FAQ','Titolo sezione','text','Domande frequenti.'],
            'faq_intro'=>['FAQ','Introduzione','textarea',"Preferisci parlarne con una persona?\nLa segreteria è a tua disposizione."],
            'contact_title'=>['Contatti','Titolo sezione','text','Contatti e indicazioni.'],
            'contact_text'=>['Contatti','Presentazione','textarea',"Dietro ogni analisi c’è una persona. Per questo uniamo il lavoro di medici, biologi e tecnici di laboratorio a un’accoglienza attenta e cordiale.\n\nNel nostro laboratorio a Centocelle trovi un punto di riferimento per le tue analisi cliniche, convenzionato con il Servizio Sanitario Nazionale."],
            'footer_text'=>['Footer','Testo','textarea',"La precisione della scienza.\nIl calore delle persone."],
            'footer_show_login'=>['Footer','Mostra «Accedi» nel footer','select','0',['0'=>'Nascondi','1'=>'Mostra']],
            'footer_login_url'=>['Footer','Link di «Accedi» (vuoto: login WordPress)','url',''],
        ];
    }
    public static function all(): array {
        $defaults=[];foreach(self::fields() as $key=>$field)$defaults[$key]=$field[3];
        return array_replace($defaults,(array)get_option('domus_site_settings',[]));
    }
    public static function hours(): array {
        $defaults=['collection_weekdays_open'=>'08:00','collection_weekdays_close'=>'10:30','collection_saturday_open'=>'08:00','collection_saturday_close'=>'10:30','results_morning_open'=>'10:00','results_morning_close'=>'14:00','results_afternoon_open'=>'15:00','results_afternoon_close'=>'17:00','saturday_closed'=>false,'hours_note'=>''];
        return array_replace($defaults,(array)get_option('domus_hours',[]));
    }
    public static function faqDefaults(): array {
        return [
            ['question'=>'Devo prenotare le mie analisi?','answer'=>'Le modalità di accesso dipendono dalla prestazione. Contatta la segreteria allo 06 23 11 843 per verificare se è necessaria la prenotazione.','enabled'=>true],
            ['question'=>'Come mi preparo al prelievo?','answer'=>'La preparazione varia in base agli esami. Chiedi al laboratorio le indicazioni specifiche prima della visita.','enabled'=>true],
            ['question'=>'Dove posso ritirare il referto?','answer'=>'Puoi concordare il ritiro con la segreteria o accedere al servizio di refertazione online.','enabled'=>true],
            ['question'=>'Dove trovo gli aggiornamenti sugli orari?','answer'=>'Consulta la sezione Orari e gli avvisi del laboratorio, oppure contatta la segreteria prima di venire.','enabled'=>true],
        ];
    }
    public static function faqs(): array {return array_values(array_filter((array)get_option('domus_faqs',self::faqDefaults()),static fn($r)=>!empty($r['enabled'])&&!empty($r['question'])));}
    public static function images(string $section): array {
        $pools=(array)get_option('domus_section_images',[]);$images=[];
        foreach((array)($pools[$section]??[]) as $id){$url=wp_get_attachment_image_url((int)$id,'large');if($url)$images[]=['url'=>$url,'alt'=>get_post_meta((int)$id,'_wp_attachment_image_alt',true),'illustrative'=>false];}
        if(!$images){$names=['hero'=>['prelievo','provette','ambiente'],'visit'=>['provette','ambiente','prelievo'],'contact'=>['ambiente']];foreach($names[$section]??[] as $name)$images[]=['url'=>get_template_directory_uri().'/frontend/assets/laboratorio/'.$name.'.jpg','alt'=>'Scena illustrativa generata: laboratorio di analisi, '.$name,'illustrative'=>true];}
        return $images;
    }
}
