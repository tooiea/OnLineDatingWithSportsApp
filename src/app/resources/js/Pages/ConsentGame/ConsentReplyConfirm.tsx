import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import getFormattedFullDateTime from '@/Components/FormattedFullDateTime';

dayjs.locale('ja');

interface Props {
  teamName: string;
  form: {
    first_preferered_date: string | null;
    second_preferered_date: string | null;
    third_preferered_date?: string | null;
    message?: string;
  };
  consent_game: {
    id: number;
    team_name: string;
    first_preferered_date: string | null;
    second_preferered_date: string | null;
    third_preferered_date?: string | null;
  };
}

const ConsentReplyConfirm: React.FC<Props> = ({ form, consent_game }) => {
  const { post } = useForm({});
  const isAccepted = (reply: string | null | undefined) => reply === '受諾';

  const wishes = [
    { label: '希望①', key: 'first_preferered_date' },
    { label: '希望②', key: 'second_preferered_date' },
    { label: '希望③', key: 'third_preferered_date' },
  ].filter(({ key }) => consent_game[key as keyof typeof consent_game]);

  const firstAcceptedIndex = wishes.findIndex(({ key }) => isAccepted(form[key as keyof typeof form] as string | null | undefined));

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.consent_game.reply.back', consent_game.id));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.consent_game.reply.complete', consent_game.id));
  };

  return (
    <AuthenticatedLayout>
      <Head title="確認画面" />
      <div className="max-w-2xl mx-auto p-4 sm:p-8">
        <div className="bg-white shadow rounded-xl p-6">
          <h2 className="text-xl sm:text-2xl font-bold text-center mb-6">📌 確認画面</h2>

          <p className="text-center text-sm text-gray-600 mb-6">
            招待元チーム：<span className="font-semibold text-black">{consent_game.team_name}</span>
          </p>

          <div className="space-y-4 mb-4">
            {wishes.map(({ label, key }, index) => {
              const reply = form[key as keyof typeof form];
              const dateValue = consent_game[key as keyof typeof consent_game] as string | null;
              const isAccept = isAccepted(reply as string | null | undefined);
              const isFirstAccepted = isAccept && index === firstAcceptedIndex;
              const cardClass = isFirstAccepted ? 'bg-green-50 border-green-300' : 'border-gray-300';

              return (
                <div
                  key={key}
                  className={`border rounded p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 ${cardClass}`}
                >
                  <div className="font-bold text-gray-800 min-w-[4rem]">{label}</div>

                  <div className="flex flex-col sm:flex-row sm:items-center sm:gap-4 flex-grow">
                    <div className="text-sm sm:text-base text-gray-800 whitespace-nowrap">
                      {getFormattedFullDateTime(dateValue || '')}
                    </div>
                    {reply && (
                      <div className="flex items-center gap-2 sm:ml-auto">
                        <span
                          className={`inline-block text-sm text-white font-semibold px-2 py-1 rounded ${
                            isAccept ? 'bg-green-500' : 'bg-red-500'
                          }`}
                        >
                          {reply}
                        </span>
                      </div>
                    )}
                  </div>
                </div>
              );
            })}
          </div>

          {firstAcceptedIndex >= 0 && (
            <p className="text-xs text-green-700 mb-2">※ 緑色の枠の日程で決定されます</p>
          )}
          <p className="text-xs text-gray-600 mb-6">
            ※複数の「受諾」がある場合、第一希望（希望①）が優先されます。
          </p>

          <div className="mb-6">
            <h3 className="text-lg font-semibold mb-2">💬 メッセージ</h3>
            <div className="bg-gray-100 p-3 rounded min-h-[80px]">
              {form.message ? (
                <pre className="whitespace-pre-wrap break-words text-sm">{form.message}</pre>
              ) : (
                <span className="text-gray-500 text-sm">（メッセージなし）</span>
              )}
            </div>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <form onSubmit={handleBack}>
              <button
                type="submit"
                className="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded"
              >
                修正する
              </button>
            </form>
            <form onSubmit={handleSubmit}>
              <button
                type="submit"
                className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded"
              >
                送信する
              </button>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
};

export default ConsentReplyConfirm;
