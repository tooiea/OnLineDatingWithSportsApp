import React from 'react';
import { Head, useForm } from '@inertiajs/react';

interface Props {
  first_preferered_date: string;
  second_preferered_date: string;
  third_preferered_date?: string;
  message?: string;
  team_id: number;
}

export default function InviteGameConfirm({ first_preferered_date, second_preferered_date, third_preferered_date, message, team_id }: Props) {
  const { post } = useForm({});

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('team.invite_game.back', { id: team_id }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('team.invite_game.complete', { id: team_id }));
  };

  return (
    <div className="container py-10 px-4 mx-auto max-w-3xl">
      <Head title="確認画面" />

      <div className="bg-white shadow-md rounded-lg p-6">
        <h1 className="text-2xl font-bold text-center mb-6">確認画面</h1>

        <div className="bg-gray-50 rounded-lg border p-4 mb-6">
          <h2 className="text-lg font-semibold border-b pb-2 mb-4">📅 招待日程</h2>

          <div className="space-y-3 text-gray-800">
            <div>
              <label className="font-semibold">第一希望日程</label>
              <div>{first_preferered_date || '—'}</div>
            </div>
            <div>
              <label className="font-semibold">第二希望日程</label>
              <div>{second_preferered_date || '—'}</div>
            </div>
            <div>
              <label className="font-semibold">第三希望日程</label>
              <div>{third_preferered_date || '—'}</div>
            </div>
            <div>
              <label className="font-semibold">メッセージ</label>
              <div className="whitespace-pre-wrap">{message || '—'}</div>
            </div>
          </div>
        </div>

        <div className="flex justify-between gap-4">
          <form onSubmit={handleBack} className="w-1/2">
            <button
              type="submit"
              className="w-full py-2 px-4 bg-gray-400 hover:bg-gray-500 text-white font-semibold rounded"
            >
              修正する
            </button>
          </form>

          <form onSubmit={handleSubmit} className="w-1/2">
            <button
              type="submit"
              className="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded"
            >
              送信する
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}
