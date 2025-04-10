import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import getFormattedFullDateTime from '@/Components/FormattedFullDateTime';

dayjs.locale('ja');

interface ConsentReplyStatus {
  id: number;
  label: string;
}

interface TeamInfo {
  id: number;
  name: string;
  image_path: string;
}

interface ConsentGame {
  id: number;
  invitee: TeamInfo;
  guest: TeamInfo;
  consent_status: string;
  game_date: string;
  first_preferered_date: string;
  second_preferered_date: string;
  third_preferered_date?: string | null;
  message?: string;
}

interface Props {
  consentGame: ConsentGame;
  replyStatuses: ConsentReplyStatus[];
  old: Record<string, any>;
  errors: Record<string, string>;
}

const ConsentReplyForm: React.FC<Props> = ({ consentGame, replyStatuses, old, errors }) => {
  const filteredStatuses = replyStatuses.filter(status => status.label !== '連絡未');

  const { data, setData, post } = useForm({
    message: old.message || '',
    first_preferered_date: old.first_preferered_date ? String(old.first_preferered_date) : '',
    second_preferered_date: old.second_preferered_date ? String(old.second_preferered_date) : '',
    third_preferered_date: old.third_preferered_date ? String(old.third_preferered_date) : '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.consent_game.reply.confirm', consentGame.id));
  };

  const renderRadioGroup = (key: keyof typeof data) => (
    <div className="flex gap-4 flex-wrap">
      {filteredStatuses.map(({ id, label }) => {
        const isAccepted = label === '受諾';
        const isDeclined = label === '辞退';

        const labelClass = isAccepted
          ? 'bg-green-100 text-green-800 border border-green-300'
          : isDeclined
          ? 'bg-red-100 text-red-800 border border-red-300'
          : 'bg-gray-100 text-gray-800 border border-gray-300';

        return (
          <label key={id} className={`inline-flex items-center gap-1 px-2 py-1 rounded text-sm ${labelClass}`}>
            <input
              type="radio"
              name={key}
              value={id}
              checked={String(data[key]) === String(id)}
              onChange={() => setData(key, String(id))}
              className="form-radio accent-current"
            />
            <span>{label}</span>
          </label>
        );
      })}
    </div>
  );

  const renderWishRow = (label: string, key: keyof typeof data, date: string | null | undefined) => {
    if (!date) return null;
    return (
      <div className="bg-white border rounded-xl shadow-sm px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div className="font-semibold text-sm sm:text-base w-full sm:w-1/2">{label}：{getFormattedFullDateTime(date)}</div>
        <div className="w-full sm:w-1/2">{renderRadioGroup(key)}</div>
        {errors[key] && <div className="text-red-500 text-sm">{errors[key]}</div>}
      </div>
    );
  };

  return (
    <AuthenticatedLayout>
      <Head title="返信画面" />
      <div className="max-w-3xl mx-auto py-10 px-4">
        <div className="space-y-8">
          <div className="bg-white shadow rounded-xl p-6">
            <div className="flex gap-4 items-center mb-4">
              <img
                src={consentGame.invitee.image_path}
                alt="チームロゴ"
                className="w-20 h-20 object-contain border rounded"
              />
              <div className="text-lg font-semibold">{consentGame.invitee.name}</div>
            </div>
            {consentGame.message && (
              <div className="bg-gray-50 p-3 rounded border mb-4 text-sm">
                <strong className="block mb-1">お相手からのメッセージ：</strong>
                <pre className="whitespace-pre-wrap break-words">{consentGame.message}</pre>
              </div>
            )}

            <div className="space-y-4">
              {renderWishRow('希望①', 'first_preferered_date', consentGame.first_preferered_date)}
              {renderWishRow('希望②', 'second_preferered_date', consentGame.second_preferered_date)}
              {renderWishRow('希望③', 'third_preferered_date', consentGame.third_preferered_date)}
            </div>

            <div className="mt-6">
              <label htmlFor="message" className="block font-semibold mb-2">返信メッセージ（任意）</label>
              <textarea
                id="message"
                className={`w-full border rounded px-3 py-2 ${errors.message ? 'border-red-500' : ''}`}
                rows={3}
                value={data.message}
                onChange={e => setData('message', e.target.value)}
              />
              {errors.message && (
                <div className="text-red-500 text-sm mt-1">{errors.message}</div>
              )}
            </div>

            <div className="flex flex-col sm:flex-row justify-center gap-4 mt-6">
              <button
                type="submit"
                className="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded"
                onClick={handleSubmit}
              >
                確認する
              </button>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
};

export default ConsentReplyForm;
