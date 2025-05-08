import React from 'react';
import { Head, useForm } from '@inertiajs/react';

interface Props {
  team: {
    name: string;
  };
  routes: {
    complete: string;
    back: string;
  };
}

const TeamJoinRegistrationConfirm: React.FC<Props> = ({ team, routes }) => {
  const { post, processing } = useForm({});

  const handleConfirm = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.complete);
  };

  const handleCancel = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.back);
  };

  return (
    <div className="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-green-100 overflow-hidden px-4 py-12">
      <Head title="確認画面" />

      {/* 背景ボール装飾 */}
      <img src="/images/ball-soccer.png" alt="Soccer Ball" className="absolute top-4 left-4 w-20" />
      <img src="/images/ball-baseball.png" alt="Baseball" className="absolute top-6 right-4 w-16" />
      <img src="/images/ball-volleyball.png" alt="Volleyball" className="absolute bottom-4 left-4 w-24" />
      <img src="/images/ball-basketball.png" alt="Basketball" className="absolute bottom-6 right-4 w-20" />

      <div className="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full z-10">
        <div className="text-center mb-6">
          <img src="/images/logo.webp" alt="OLDWS Logo" className="mx-auto w-20 mb-2" />
          <h2 className="text-xl font-bold text-green-600">✅ 確認画面</h2>
          <p className="text-sm text-gray-600 mt-2">以下のチームで登録しますか？</p>
        </div>

        <div className="bg-gray-100 rounded-lg p-4 mb-6">
          <p className="text-sm text-gray-600 mb-1">チーム名：</p>
          <p className="text-base font-bold text-indigo-700">{team.name}</p>
          <p className="text-xs text-gray-500 mt-2">※このチームで登録する場合は「登録する」ボタンを押してください</p>
        </div>

        <form onSubmit={handleConfirm} className="space-y-3">
          <button
            type="submit"
            disabled={processing}
            className="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 shadow-md transition duration-300"
          >
            登録する
          </button>
        </form>

        <form onSubmit={handleCancel} className="mt-2">
          <button
            type="submit"
            className="w-full border border-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg hover:bg-gray-100 transition duration-300"
          >
            キャンセル
          </button>
        </form>
      </div>
    </div>
  );
};

export default TeamJoinRegistrationConfirm;
