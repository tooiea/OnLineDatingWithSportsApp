import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ConsentStatusClass from '@/Components/ConsentStatusClass';
import getFormattedFullDateTime from '@/Components/FormattedFullDateTime';
dayjs.locale('ja');


interface TeamInfo {
  id: string;
  name: string;
  image_path: string;
  url: string;
}

interface ReplyMessage {
  id: string;
  message: string;
  created_at: string;
  team_id: string;
}

interface ConsentGame {
  id: string;
  invitee: TeamInfo;
  guest: TeamInfo;
  consent_status: number;
  consent_status_label: string;
  game_date?: string;
  first_preferered_date?: string;
  second_preferered_date?: string;
  third_preferered_date?: string;
  message?: string;
  created_at: string;
  replies: ReplyMessage[];
}

interface MyTeam {
  id: string;
  name: string;
  image_path: string;
}

interface Props {
  myTeam: MyTeam;
  consentGame: ConsentGame;
}

const ConsentDetail: React.FC<Props> = ({ myTeam, consentGame }) => {
  const isInviter = consentGame.invitee.id === myTeam.id;
  const targetTeam = isInviter ? consentGame.guest : consentGame.invitee;

  const { data, setData, post, processing } = useForm({
    consent_game_id: consentGame.id,
    message: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.consent_game.reply.message', consentGame.id), {
      preserveScroll: true,
      onSuccess: () => {
        setData('message', '');
      },
    });
  };

  const renderMessage = (msg?: string) =>
    typeof msg === 'string'
      ? msg.split('\n').map((line, i) => <p key={i} className="mb-1">{line}</p>)
      : null;

  return (
    <AuthenticatedLayout>
      <Head title="招待情報" />
      <div className="max-w-4xl mx-auto px-4 py-8">
        <div className="bg-white shadow rounded-lg overflow-hidden">
          {/* ヘッダー */}
          <div className="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
            <h2 className="font-semibold text-lg">招待情報</h2>
            <span className={`text-sm px-3 py-1 rounded-lg ${ConsentStatusClass(consentGame.consent_status)}`}>
              {consentGame.consent_status_label}
            </span>
          </div>

          {/* チーム情報（横並び表示） */}
          <div className="flex flex-row items-center justify-center space-x-4 md:space-x-12 mb-8 px-2 pt-6">
            {/* 招待側 */}
            <div className="flex flex-col items-center text-center relative min-w-[130px]">
              <div className="relative w-16 h-16">
                <img src={consentGame.invitee.image_path} className="w-16 h-16 rounded-full object-cover" />
                {myTeam.id === consentGame.invitee.id && (
                  <div className="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-[10px] font-semibold rounded px-2 py-0.5">
                    myteam
                  </div>
                )}
              </div>
              <div className="mt-2 text-xs font-bold max-w-[150px] truncate whitespace-nowrap overflow-hidden">{consentGame.invitee.name}</div>
              <div className="text-[10px] text-gray-500">招待側</div>
            </div>

            {/* 招待された側 */}
            <div className="flex flex-col items-center text-center relative min-w-[130px]">
              <div className="relative w-16 h-16">
                <img src={consentGame.guest.image_path} className="w-16 h-16 rounded-full object-cover" />
                {myTeam.id === consentGame.guest.id && (
                  <div className="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-[10px] font-semibold rounded px-2 py-0.5">
                    myteam
                  </div>
                )}
              </div>
              <div className="mt-2 text-xs font-bold max-w-[150px] truncate whitespace-nowrap overflow-hidden">{consentGame.guest.name}</div>
              <div className="text-[10px] text-gray-500">招待された側</div>
            </div>
          </div>

          {/* 内容 */}
          <div className="border-t p-6 space-y-4">
            {/* 希望日程 */}
            <div>
              <h3 className="font-semibold text-sm mb-1">希望日程</h3>
              {[consentGame.first_preferered_date, consentGame.second_preferered_date, consentGame.third_preferered_date]
                .map((date, idx) => {
                  if (!date) return null;
                  const label = `${['①', '②', '③'][idx]}`;
                  const isDecided = consentGame.consent_status_label === '試合日時決定' && consentGame.game_date === date;
                  return (
                    <div key={idx} className="text-sm flex items-center space-x-2">
                      <span>{label} {getFormattedFullDateTime(date)}</span>
                      {isDecided && (
                        <span className="px-1 py-0.5 bg-yellow-100 text-yellow-800 text-xs rounded border border-yellow-300">
                          決定
                        </span>
                      )}
                    </div>
                  );
                })}
            </div>

            {/* メッセージ履歴 */}
            <div>
              <h3 className="font-semibold text-sm mb-2">メッセージ履歴</h3>
              {consentGame.message && (
                <div className={`flex mt-4 ${consentGame.invitee.id === myTeam.id ? 'justify-end' : ''}`}>
                  <div className="flex items-start space-x-2">
                    {myTeam.id !== consentGame.invitee.id && (
                      <img src={consentGame.invitee.image_path} className="w-8 h-8 rounded-full" />
                    )}
                    <div className="bg-gray-100 p-3 rounded-lg max-w-md">
                      {renderMessage(consentGame.message)}
                      <div className="text-right text-xs text-gray-500 mt-1">
                        {getFormattedFullDateTime(consentGame.created_at)}
                      </div>
                    </div>
                    {myTeam.id === consentGame.invitee.id && (
                      <img src={consentGame.invitee.image_path} className="w-8 h-8 rounded-full" />
                    )}
                  </div>
                </div>
              )}

              {consentGame.replies.map((reply) => {
                if (!reply.message) return null;
                const isOwn = reply.team_id === myTeam.id;
                const sender = isOwn ? myTeam : targetTeam;
                return (
                  <div key={reply.id} className={`flex mt-4 ${isOwn ? 'justify-end' : ''}`}>
                    <div className="flex items-start space-x-2">
                      {!isOwn && <img src={sender.image_path} className="w-8 h-8 rounded-full" />}
                      <div className="bg-gray-100 p-3 rounded-lg max-w-md">
                        {renderMessage(reply.message)}
                        <div className="text-right text-xs text-gray-500 mt-1">
                          {getFormattedFullDateTime(reply.created_at)}
                        </div>
                      </div>
                      {isOwn && <img src={sender.image_path} className="w-8 h-8 rounded-full" />}
                    </div>
                  </div>
                );
              })}
            </div>

            {/* メッセージ入力フォーム */}
            <form onSubmit={handleSubmit} className="flex space-x-2 pt-4 border-t">
              <input
                type="text"
                name="message"
                className="flex-grow border rounded px-3 py-2"
                placeholder="メッセージを入力して"
                value={data.message}
                onChange={(e) => setData('message', e.target.value)}
              />
              <button type="submit" disabled={processing} className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                返信
              </button>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
};

export default ConsentDetail;
