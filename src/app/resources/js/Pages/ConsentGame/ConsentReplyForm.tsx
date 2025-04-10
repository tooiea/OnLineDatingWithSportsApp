import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

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

  const formatDate = (date: string) => dayjs(date).format('YYYY/MM/DD HH:mm');

  const renderRadioGroup = (label: string, key: keyof typeof data) => (
    <div className="mb-6">
      <label className="block font-semibold mb-2">{label}</label>
      <div className="flex flex-wrap gap-4">
        {filteredStatuses.map(({ id, label }) => (
          <label key={id} className="inline-flex items-center space-x-2">
            <input
              type="radio"
              name={key}
              value={id}
              checked={String(data[key]) === String(id)}
              onChange={() => setData(key, String(id))}
              className="form-radio"
            />
            <span>{label}</span>
          </label>
        ))}
      </div>
      {errors[key as string] && (
        <div className="text-red-500 text-sm mt-1">{errors[key as string]}</div>
      )}
    </div>
  );

  return (
    <AuthenticatedLayout>
      <Head title="返信画面" />
      <div className="max-w-3xl mx-auto py-10 px-4">
        <div className="bg-white shadow rounded-lg p-6 space-y-8">
          <div>
            <h2 className="text-lg font-semibold mb-4">① チーム情報</h2>
            <div className="flex gap-4">
              <img
                src={consentGame.invitee.image_path}
                alt="チームロゴ"
                className="w-24 h-24 object-contain border rounded"
              />
              <div className="space-y-2">
                <div>第一希望：{formatDate(consentGame.first_preferered_date)}</div>
                <div>第二希望：{formatDate(consentGame.second_preferered_date)}</div>
                {consentGame.third_preferered_date && (
                  <div>第三希望：{formatDate(consentGame.third_preferered_date)}</div>
                )}
              </div>
            </div>
          </div>

          <div>
            <label className="font-semibold block mb-2">相手からのメッセージ</label>
            <textarea
              className="w-full border rounded px-3 py-2 bg-gray-100"
              rows={3}
              readOnly
              value={consentGame.message || ''}
            />
          </div>

          <hr />

          {renderRadioGroup('第一希望の対応', 'first_preferered_date')}
          {renderRadioGroup('第二希望の対応', 'second_preferered_date')}
          {consentGame.third_preferered_date &&
            renderRadioGroup('第三希望の対応', 'third_preferered_date')}

          <div>
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

          <div className="text-center">
            <button
              type="submit"
              className="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded"
              onClick={handleSubmit}
            >
              確認する
            </button>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
};

export default ConsentReplyForm;
