<?php
namespace Domus\Data;
final class Posts {
    public function currentQuery(): array {
        global $wp_query;
        return $this->normalize($wp_query->posts??[]);
    }
    public function latest(int $limit): array {
        return $this->normalize(get_posts(['post_type'=>'post','post_status'=>'publish','posts_per_page'=>max(1,$limit),'orderby'=>'date','order'=>'DESC','suppress_filters'=>false]),false);
    }
    public function related(int $postId): array {
        $categories = wp_get_post_categories($postId);
        if (!$categories || is_wp_error($categories)) return [];
        return $this->normalize(get_posts([
            'post_type' => 'post', 'post_status' => 'publish',
            'posts_per_page' => 3, 'post__not_in' => [$postId],
            'category__in' => $categories, 'orderby' => 'date', 'order' => 'DESC',
            'suppress_filters' => false,
        ]), false);
    }
    private function normalize(array $posts,bool $includeContent=true): array {
        $previous=$GLOBALS['post']??null;
        $items=[];
        try {
            foreach($posts as $post) {
                $GLOBALS['post']=$post;
                setup_postdata($post);
                $items[]=['id'=>$post->ID,'title'=>html_entity_decode(get_the_title($post), ENT_QUOTES | ENT_HTML5, 'UTF-8'),'url'=>esc_url(get_permalink($post)),'excerpt_html'=>wpautop(wp_kses_post(wp_trim_words(get_the_excerpt($post),25,''))),'excerpt'=>get_the_excerpt($post),'content_html'=>$includeContent ? apply_filters('the_content',$post->post_content) : '', 'image_html'=>get_the_post_thumbnail($post,'regina-lite-homepage-blog-posts')];
            }
        } finally {
            wp_reset_postdata();
            if($previous) { $GLOBALS['post']=$previous; setup_postdata($previous); }
            else unset($GLOBALS['post']);
        }
        return $items;
    }
}
