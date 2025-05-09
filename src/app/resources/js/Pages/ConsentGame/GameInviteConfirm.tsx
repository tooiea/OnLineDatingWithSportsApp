import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import getFormattedFullDateTime from '@/Components/FormattedFullDateTime';
import LabelBlock from '@/Components/LabelBlock';

interface Props {
  first_preferered_date: string;
  second_preferered_date: string;
  third_preferered_date?: string;
  message?: string;
  routes: {
    complete: string;
    back: string;
  }
}

export default function InviteGameConfirm({
  first_preferered_date,
  second_preferered_date,
  third_preferered_date,
  message,
  routes,
}: Props) {
  const { post } = useForm({});

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.back);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.complete);
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
              <LabelBlock label='第一希望日程'>{getFormattedFullDateTime(first_preferered_date)}</LabelBlock>
            </div>
            <div>
              <LabelBlock label='第二希望日程'>{getFormattedFullDateTime(second_preferered_date)}</LabelBlock>
            </div>
            <div>
              <LabelBlock label='第三希望日程'>{getFormattedFullDateTime(third_preferered_date)}</LabelBlock>
            </div>
            <div>
              <LabelBlock label='メッセージ'>{message || '—'}</LabelBlock>
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
