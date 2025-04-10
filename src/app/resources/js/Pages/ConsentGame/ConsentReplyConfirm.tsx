import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

// dayjs ロケール設定
dayjs.locale('ja');

interface Props {
  form: {
    first_preferered_date: string;
    second_preferered_date: string;
    third_preferered_date?: string | null;
    message?: string;
  };
  consent_game: {
    id: number;
    first_preferered_date: string;
    second_preferered_date: string;
    third_preferered_date?: string | null;
  };
}

const ConsentReplyConfirm: React.FC<Props> = ({ form, consent_game }) => {
  const { post } = useForm({});

  const formatDateParts = (date: string | null | undefined) => {
    if (!date) return { date: '', time: '' };
    const d = dayjs(date);
    return {
      date: d.format('YYYY年MM月DD日'),
      time: d.format('HH時mm分')
    };
  };

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.consent_game.reply.back', consent_game.id));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.consent_game.reply.complete', consent_game.id));
  };

  const isAccepted = (reply: string) => reply === '受諾';

  const wishes = [
    { label: '要望1', key: 'first_preferered_date' },
    { label: '要望2', key: 'second_preferered_date' },
    { label: '要望3', key: 'third_preferered_date' }
  ].filter(({ key }) => form[key as keyof typeof form] !== undefined);

  const firstAcceptedIndex = wishes.findIndex(({ key }) => {
    const reply = form[key as keyof typeof form];
    return typeof reply === 'string' && isAccepted(reply);
  });

  const getComment = (index: number, reply: string) => {
    return isAccepted(reply) && index === firstAcceptedIndex
      ? 'この日程で決まります'
      : null;
  };

  return (
    <AuthenticatedLayout>
      <Head title="確認画面" />
      <div className="max-w-4xl mx-auto p-4 sm:p-8">
        <div className="bg-white shadow rounded-xl p-6">
          <h2 className="text-xl sm:text-2xl font-bold text-center mb-6">📌 確認画面</h2>

          <div className="mb-6">
            <h3 className="text-lg font-semibold mb-4">📅 希望日程へのお返事</h3>
            <table className="w-full border text-sm sm:text-base">
              <thead>
                <tr className="bg-gray-100 text-left">
                  <th className="p-2 sm:p-3 w-1/4">日程</th>
                  <th className="p-2 sm:p-3 w-1/4">返事</th>
                  <th className="p-2 sm:p-3 w-1/2">日時</th>
                </tr>
              </thead>
              <tbody>
                {wishes.map(({ label, key }, index) => {
                  const reply = form[key as keyof typeof form];
                  const dateValue = consent_game[key as keyof typeof consent_game] as string;
                  const { date, time } = formatDateParts(dateValue);
                  const comment = reply ? getComment(index, reply) : null;
                  return (
                    <tr key={key} className="border-t">
                      <td className="p-2 sm:p-3 font-medium">{label}</td>
                      <td className="p-2 sm:p-3">
                        <span
                          className={`inline-block px-2 py-1 text-white text-sm rounded ${reply === '受諾' ? 'bg-green-500' : 'bg-red-500'}`}
                        >
                          {reply}
                        </span>
                        {comment && (
                          <div className="text-xs text-gray-500 mt-1">{comment}</div>
                        )}
                      </td>
                      <td className="p-2 sm:p-3">
                        <div>{date}</div>
                        <div className="text-sm text-gray-600">{time}</div>
                      </td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
            <p className="text-xs text-gray-600 mt-2">※複数の「受諾」がある場合、第一希望（要望1）が優先されます。</p>
          </div>

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
              <button type="submit" className="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded">
                修正する
              </button>
            </form>
            <form onSubmit={handleSubmit}>
              <button type="submit" className="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded">
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
