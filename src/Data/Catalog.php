<?php
namespace Domus\Data;
final class Catalog {
    public static function plainText(string $value): string {
        $decoded=html_entity_decode(wp_strip_all_tags($value),ENT_QUOTES|ENT_HTML5,'UTF-8');
        return trim(preg_replace('/[\s\x{00A0}]+/u',' ',$decoded)??$decoded);
    }
    public static function item(\WP_Post $post,bool $includeContent=true): array {
        $meta=static fn($key)=>get_post_meta($post->ID,'_domus_'.$key,true);
        $price=$meta('price');$amount=$price!==''?number_format((float)$price,2,',',''):null;$parts=$amount!==null?explode(',',$amount):[];
        $image=get_the_post_thumbnail_url($post,'large');$imageId=get_post_thumbnail_id($post);
        $tests=array_values(array_filter(array_map('trim',explode("\n",(string)$meta('tests')))));
        $terms=$post->post_type==='post'?get_the_category($post->ID):[];
        $terms=array_values(array_filter($terms,static fn($term)=>$term->term_id!==(int)get_option('default_category')));
        $groups=array_map(static fn($term)=>$term->slug,$terms);$labels=array_map(static fn($term)=>$term->name,$terms);
        return ['updated'=>$post->post_modified_gmt,'id'=>$post->ID,'type'=>$post->post_type,'title'=>$meta('card_title')?:html_entity_decode(get_the_title($post),ENT_QUOTES|ENT_HTML5,'UTF-8'),'original_title'=>html_entity_decode(get_the_title($post),ENT_QUOTES|ENT_HTML5,'UTF-8'),'url'=>get_permalink($post),'summary'=>self::plainText($meta('summary')?:get_the_excerpt($post)),'content_html'=>$includeContent?apply_filters('the_content',$post->post_content):'','price'=>$amount,'price_whole'=>$parts[0]??'','price_decimal'=>$parts[1]??'','group'=>implode(' ',$groups),'group_label'=>implode(' · ',$labels),'categories'=>array_map(static fn($term)=>['slug'=>$term->slug,'name'=>$term->name],$terms),'tests'=>$tests,'tests_preview'=>implode(', ',array_slice($tests,0,3)),'test_count_label'=>$meta('test_count_label'),'preparation'=>$meta('preparation'),'report'=>$meta('report'),'booking'=>(bool)$meta('booking'),'image'=>['url'=>$image?:($post->post_type==='post'?get_template_directory_uri().'/frontend/assets/prototype/assets/images/pacchetti/checkup.jpg':''),'alt'=>$imageId?get_post_meta($imageId,'_wp_attachment_image_alt',true):''],'start'=>$meta('start'),'end'=>$meta('end'),'date_label'=>self::dateLabel($post->ID),'is_active'=>self::activeOn($post->ID),'requires_review'=>(bool)$meta('requires_review')];
    }
    public static function items(string $type): array {
        $query=['post_type'=>$type,'post_status'=>'publish','posts_per_page'=>100,'orderby'=>'ID','order'=>'ASC','suppress_filters'=>false];
        if($type!=='avvisi')$query['meta_query']=[['key'=>'_domus_enabled','value'=>'1']];
        $posts=get_posts($query);
        $key=$type==='avvisi'?'_domus_priority':'_domus_order';usort($posts,static function($a,$b)use($type,$key){$cmp=(int)get_post_meta($a->ID,$key,true)<=>(int)get_post_meta($b->ID,$key,true);return ($type==='avvisi'?-$cmp:$cmp)?:($a->ID<=>$b->ID);});
        return array_map(static fn($post)=>self::item($post,$type==='avvisi'),$posts);
    }
    public static function related(?array $current,array $packages): array {
        if(!$current||$current['type']!=='post')return [];
        $categories=array_column($current['categories'],'slug');
        if(!$categories)return [];
        return array_slice(array_values(array_filter($packages,static fn($item)=>$item['id']!==$current['id']&&array_intersect($categories,array_column($item['categories'],'slug')))),0,3);
    }
    public static function activeOn(int $id,?string $date=null): bool {
        if(get_post_type($id)==='avvisi'){
            if(get_post_status($id)!=='publish')return false;
        }elseif(!get_post_meta($id,'_domus_enabled',true))return false;
        $start=get_post_meta($id,'_domus_start',true);$end=get_post_meta($id,'_domus_end',true);$today=$date??wp_date('Y-m-d',null,wp_timezone());
        if($start&&!$end)$end=$start;if($end&&!$start)$start=$end;
        return (!$start||$today>=$start)&&(!$end||$today<=$end);
    }
    public static function dateLabel(int $id): string {
        $start=get_post_meta($id,'_domus_start',true);$end=get_post_meta($id,'_domus_end',true);$format=static fn($d)=>$d?wp_date('d/m/Y',(new \DateTimeImmutable($d,wp_timezone()))->getTimestamp(),wp_timezone()):'';
        if($start&&$end&&$start!==$end)return 'Valido dal '.$format($start).' al '.$format($end);
        return $start||$end?'Valido il '.$format($start?:$end):'';
    }
}
