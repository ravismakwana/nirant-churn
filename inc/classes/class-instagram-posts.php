<?php
/**
 * Fetch Instagram Reels via AJAX
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Instagram_Posts {
    use Singleton;

    protected function __construct() {
        $this->setup_hooks();
    }

    protected function setup_hooks() {
        add_action('wp_ajax_fetch_instagram_reels', [$this, 'fetch_instagram_reels_ajax']);
        add_action('wp_ajax_nopriv_fetch_instagram_reels', [$this, 'fetch_instagram_reels_ajax']);
    }

    public function fetch_instagram_reels_ajax() {
        $access_token = 'IGAAPNuiDJa69BZAE5CeEctOTRnVGpoT012ZAFMzVmlueE44RWFEMG96ZAVFyUVNHNmNlNmJHRVBOX0szYkRsS2JSUnhZAUS1LazZA5RzRoS1RqaTVCWEpyOWVLUUk4THlpUUo3LV9sMG1mOWpXWWFfd0lkSVhn'; // Replace with your Instagram access token
		$user_id = '17841471064384817'; // Replace with your Instagram User ID
		$limit = 5; // Number of reels to fetch

        if (empty($access_token) || empty($user_id)) {
            wp_send_json_error(['message' => 'Missing Instagram credentials']);
            return;
        }

        $url = esc_url_raw("https://graph.instagram.com/{$user_id}/media?fields=id,media_type,media_url,permalink,thumbnail_url&access_token={$access_token}&limit={$limit}");

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'Unable to fetch Instagram Reels']);
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (empty($data) || empty($data['data'])) {
            wp_send_json_error(['message' => 'No Reels found']);
            return;
        }

        $html = '';

        foreach ($data['data'] as $reel) {
            if ($reel['media_type'] === 'VIDEO') {
                $thumbnail = !empty($reel['thumbnail_url']) ? esc_url($reel['thumbnail_url']) : esc_url($reel['media_url']);
                $video_url = esc_url($reel['media_url']);

                $html .= '<div class="reel-item p-2">';
                $html .= '<a href="' . $video_url . '" class="popup-video bg-white d-block rounded-circle p-1 border border-3 border-primary">';
                $html .= '<img src="' . $thumbnail . '" class="reel-thumbnail rounded-circle" alt="Instagram Reel" height="60" width="60">';
                $html .= '</a>';
                $html .= '</div>';
            }
        }

        wp_send_json_success(['html' => $html]);
    }
}
