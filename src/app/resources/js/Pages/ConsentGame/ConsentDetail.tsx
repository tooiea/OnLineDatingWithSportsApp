import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
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
  consent_status: string;
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

  const getFormattedDateTime = (date?: string) =>
    date ? dayjs(date).format('YYYY年MM月DD日 HH時mm分') : 'ー';

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.consent_game.reply.message', consentGame.id), {
      preserveScroll: true,
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
        <div className="bg-white shadow rounded-lg">
          <div className="border-b px-6 py-4 font-semibold text-lg">招待情報</div>
          <div className="p-6">
            <div className="flex flex-col md:flex-row md:items-center md:justify-center space-y-4 md:space-y-0 md:space-x-12 mb-8">
              <div className="text-center relative">
                <img src={consentGame.invitee.image_path} className="w-16 h-16 rounded-full mx-auto" />
                {myTeam.id === consentGame.invitee.id && (
                  <div className="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded px-2 py-0.5 whitespace-nowrap">myteam</div>
                )}
                <div className="mt-2 text-sm font-bold">{consentGame.invitee.name}</div>
                <div className="text-xs text-gray-500">招待側</div>
              </div>

              <div className="flex flex-col items-center justify-center space-y-1 md:space-y-0 md:space-x-4 md:flex-row">
                <div className="text-sm text-gray-500">進捗状況</div>
                <span className="inline-block px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full whitespace-nowrap">
                  {consentGame.consent_status}
                </span>
                <div className="text-2xl text-gray-400 md:hidden">↓</div>
                <div className="hidden md:block text-2xl text-gray-400">→</div>
              </div>

              <div className="text-center relative">
                <img src={consentGame.guest.image_path} className="w-16 h-16 rounded-full mx-auto" />
                {myTeam.id === consentGame.guest.id && (
                  <div className="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded px-2 py-0.5 whitespace-nowrap">myteam</div>
                )}
                <div className="mt-2 text-sm font-bold">{consentGame.guest.name}</div>
                <div className="text-xs text-gray-500">招待された側</div>
              </div>
            </div>

            <div className="space-y-4">
              {consentGame.consent_status === '承諾' ? (
                <div className="space-y-2">
                  <div className="font-semibold mb-1">試合決定日時:</div>
                  <p>{getFormattedDateTime(consentGame.game_date)}</p>
                </div>
              ) : consentGame.consent_status === '辞退' ? (
                <div className="text-center text-gray-500">承認日程 -</div>
              ) : (
                <div className="space-y-1">
                  <div className="font-semibold">希望日程</div>
                  <div><span className="font-semibold">希望①：</span>{getFormattedDateTime(consentGame.first_preferered_date)}</div>
                  <div><span className="font-semibold">希望②：</span>{getFormattedDateTime(consentGame.second_preferered_date)}</div>
                  {consentGame.third_preferered_date && (
                    <div><span className="font-semibold">希望③：</span>{getFormattedDateTime(consentGame.third_preferered_date)}</div>
                  )}
                </div>
              )}
            </div>

            <div className="mt-6">
              <div className="font-semibold mb-2">メッセージ履歴</div>
              {consentGame.message && (
                <div className={`flex mt-4 ${isInviter ? 'justify-end' : ''}`}>
                  <div className="flex items-start space-x-2">
                    {!isInviter && (
                      <img src={consentGame.invitee.image_path} className="w-10 h-10 rounded-full" />
                    )}
                    <div className="bg-gray-100 p-3 rounded-lg max-w-md">
                      {renderMessage(consentGame.message)}
                      <div className="text-right text-xs text-gray-500 mt-1">
                        {getFormattedDateTime(consentGame.created_at)}
                      </div>
                    </div>
                    {isInviter && (
                      <img src={consentGame.invitee.image_path} className="w-10 h-10 rounded-full" />
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
                      {!isOwn && (
                        <img src={sender.image_path} className="w-10 h-10 rounded-full" />
                      )}
                      <div className="bg-gray-100 p-3 rounded-lg max-w-md">
                        {renderMessage(reply.message)}
                        <div className="text-right text-xs text-gray-500 mt-1">
                          {getFormattedDateTime(reply.created_at)}
                        </div>
                      </div>
                      {isOwn && (
                        <img src={sender.image_path} className="w-10 h-10 rounded-full" />
                      )}
                    </div>
                  </div>
                );
              })}
            </div>
          </div>

          <div className="border-t p-4">
            <form onSubmit={handleSubmit} className="flex space-x-2">
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
