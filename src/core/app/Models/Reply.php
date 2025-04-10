<?php

namespace App\Models;

use App\Mail\SendMailer;
use App\Notifications\ConsentGameReplyNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

class Reply extends Model
{
    use Notifiable;
    use HasFactory;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $fillable = [
        'consent_game_id',
        'team_id',
        'message',
    ];

    /**
     * 返信内容を新規登録
     *
     * @param int $consent_games_id
     * @param array $customValues
     * @return void
     */
    public function createReply($consents, $customValues)
    {
        $values = [
            'consent_game_id' => $consents->consent_games_id,
            'team_id' => $consents->guest_id,
            'message' => '',
        ];

        if (isset($customValues['message'])) {
            $values['message'] = $customValues['message'];
        }

        $this->create($values);

        $queryTeamMember = TeamMember::where('team_id', $consents->invitee_id);
        $user = $queryTeamMember->with('user')->first();
        $myTeam = Team::where('id', $consents->guest_id)->first();

        // 返信の通知を送信
        $this->consentGameNotification($user, $myTeam);
    }

    /**
     * 招待への返信お知らせメール送信
     *
     * @param array $customValues
     * @param object $user
     * @return void
     */
    public function consentGameNotification($user, $myTeam)
    {
        $this->notify(new ConsentGameReplyNotification($user, $myTeam, new SendMailer()));
    }

    /**
     * ユーザがLINEidを登録済みの場合、メッセージをLINE公式に送信
     *
     * @param object $data
     * @param object $myTeam
     * @return void
     */
    public static function replyByLine($data, $myTeam)
    {
        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($data->message);
        // $response = $bot->pushMessage($myTeam->user->line_login_id, $textMessageBuilder);

        $bot->pushMessage($myTeam->user->line_login_id, $textMessageBuilder);


        $bubble = BubbleContainerBuilder::builder()
            // 公開されている画像(表示権限がある)
            ->setHero(
                ImageComponentBuilder::builder()
                    ->setUrl('https://source.unsplash.com/random/800x600')
                    ->setSize(ComponentImageSize::FULL)
                    ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
                    ->setAspectMode(ComponentImageAspectMode::COVER)
            )
            ->setBody(
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        TextComponentBuilder::builder()
                            ->setText('メッセージが届いてます。ご確認ください')
                            ->setWrap(true),
                    ])
            )
            ->setFooter(
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        ButtonComponentBuilder::builder()
                            ->setAction(new UriTemplateActionBuilder('詳細はこちら', 'https://google.com'))
                    ])
            );

        $messageBuilder = new FlexMessageBuilder($data->message, $bubble);
        // 通知で表示されている文字列
        $response = $bot->pushMessage($myTeam->user->line_login_id, $messageBuilder);
        Log::info(print_r($response));
        // $response = $bot->pushMessage($myTeam->user->line_login_id, $messageBuilder);
        // Check response
        if (!$response->isSucceeded()) {
            // handle error
        }
    }
}
