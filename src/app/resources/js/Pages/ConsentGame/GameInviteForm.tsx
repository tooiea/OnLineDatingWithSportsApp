import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

interface GuestTeam {
  id: number;
  name: string;
  url: string;
  image_path: string;
}

interface Props {
  guestTeam: GuestTeam;
  old: Record<string, any>;
  errors: Record<string, string>;
  routes: {
    confirm: string;
  }
}

export default function GameInviteForm({ guestTeam, old, errors, routes }: Props) {
  const { data, setData, post, processing } = useForm({
    first_preferered_date: old.first_preferered_date || '',
    second_preferered_date: old.second_preferered_date || '',
    third_preferered_date: old.third_preferered_date || '',
    message: old.message || '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.confirm);
  };

  // 本日より7日後のISO文字列（ローカルタイム考慮）
  const now = new Date();
  now.setDate(now.getDate() + 7);
  const timezoneOffset = now.getTimezoneOffset() * 60000;
  now.setHours(0, 0, 0, 0);
  const localISOTime = new Date(now.getTime() - timezoneOffset).toISOString().slice(0, 16);

  return (
    <AuthenticatedLayout>
      <Head title="練習試合の招待フォーム" />
      <div className="max-w-4xl mx-auto py-10 px-4">
        <h2 className="text-2xl font-bold text-center mb-8">Let's invite to GAME!</h2>

        <form onSubmit={handleSubmit} className="space-y-10">
          {/* チーム情報 */}
          <div className="bg-white shadow-md rounded-lg p-6">
            <h3 className="text-lg font-semibold border-b pb-2 mb-4">🎌 招待チーム情報</h3>
            <div className="space-y-4">
              <div>
                <label className="font-semibold">チーム名</label>
                <div className="text-gray-800">{guestTeam.name}</div>
              </div>
              <div>
                <label className="font-semibold">チームURL</label>
                <div>
                  <a
                    href={guestTeam.url}
                    className="text-blue-600 underline break-all"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    {guestTeam.url}
                  </a>
                </div>
              </div>
              <div>
                <label className="font-semibold">チームロゴ</label>
                <div className="mt-2">
                  <img
                    src={guestTeam.image_path}
                    alt="招待チームロゴ"
                    className="w-24 h-24 border rounded object-contain"
                  />
                </div>
              </div>
            </div>
          </div>

          {/* 招待日程入力 */}
          <div className="bg-white shadow-md rounded-lg p-6">
            <h3 className="text-lg font-semibold border-b pb-2 mb-4">📅 招待希望日程</h3>
            <p className="text-sm text-gray-600 mb-4">
              ※以下の第一希望から第三希望の日程を選択してください。
              <br/> ※本日より7日以上先を指定してください。
            </p>
            <div className="space-y-4">
              <div>
                <label className="font-semibold">第一希望日程</label>
                <input
                  type="datetime-local"
                  min={localISOTime}
                  className={`w-full border rounded px-3 py-2 ${errors.first_preferered_date ? 'border-red-500' : ''}`}
                  value={data.first_preferered_date}
                  onChange={e => setData('first_preferered_date', e.target.value)}
                />
                {errors.first_preferered_date && (
                  <p className="text-sm text-red-500">{errors.first_preferered_date}</p>
                )}
              </div>

              <div>
                <label className="font-semibold">第二希望日程</label>
                <input
                  type="datetime-local"
                  min={localISOTime}
                  className={`w-full border rounded px-3 py-2 ${errors.second_preferered_date ? 'border-red-500' : ''}`}
                  value={data.second_preferered_date}
                  onChange={e => setData('second_preferered_date', e.target.value)}
                />
                {errors.second_preferered_date && (
                  <p className="text-sm text-red-500">{errors.second_preferered_date}</p>
                )}
              </div>

              <div>
                <label className="font-semibold">第三希望日程</label>
                <input
                  type="datetime-local"
                  min={localISOTime}
                  className={`w-full border rounded px-3 py-2 ${errors.third_preferered_date ? 'border-red-500' : ''}`}
                  value={data.third_preferered_date}
                  onChange={e => setData('third_preferered_date', e.target.value)}
                />
                {errors.third_preferered_date && (
                  <p className="text-sm text-red-500">{errors.third_preferered_date}</p>
                )}
              </div>

              <div>
                <label className="font-semibold">メッセージ</label>
                <textarea
                  rows={4}
                  className={`w-full border rounded px-3 py-2 ${errors.message ? 'border-red-500' : ''}`}
                  value={data.message}
                  onChange={e => setData('message', e.target.value)}
                />
                {errors.message && (
                  <p className="text-sm text-red-500">{errors.message}</p>
                )}
              </div>
            </div>
          </div>

          <div className="text-center">
            <button
              type="submit"
              className="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded"
              disabled={processing}
            >
              確認する
            </button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  );
}
