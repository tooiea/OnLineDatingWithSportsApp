import React from 'react';
import { Head, useForm } from '@inertiajs/react';

interface Props {
  sportAffiliationType: string;
  sportAffiliationLabel: string;
  teamName: string;
  teamUrl: string;
  prefecture: string;
  prefectureLabel: string;
  address: string;
  name: string;
  email: string;
  password: string;
  teamLogoUrl?: string;
}

export default function TeamRegistrationConfirm({
  sportAffiliationLabel,
  teamName,
  teamUrl,
  prefectureLabel,
  address,
  name,
  email,
  teamLogoUrl,
}: Props) {
  const { post, processing } = useForm({});

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('temp_register.team.complete'), {
      forceFormData: true,
    });
  };

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('temp_register.team.back'), {
      forceFormData: true,
    });
  };

  return (
    <div className="container py-10 px-4 mx-auto max-w-3xl">
      <Head title="登録内容の確認" />

      <h1 className="text-2xl font-bold text-center mb-8">チーム登録内容の確認</h1>

      <form onSubmit={handleSubmit} className="space-y-8">
        <div className="bg-white shadow-md rounded-lg p-6">
          <h2 className="text-lg font-semibold border-b pb-2 mb-4">👤 ユーザー情報</h2>
          <div className="space-y-3">
            <div>
              <label className="font-semibold">ニックネーム</label>
              <div className="text-gray-800">{name}</div>
            </div>
            <div>
              <label className="font-semibold">メールアドレス</label>
              <div className="text-gray-800">{email}</div>
            </div>
            <div>
              <label className="font-semibold">パスワード</label>
              <div className="text-gray-400">********</div>
            </div>
          </div>
        </div>

        <div className="bg-white shadow-md rounded-lg p-6">
          <h2 className="text-lg font-semibold border-b pb-2 mb-4">🏆 チーム情報</h2>
          <div className="space-y-3">
            <div>
              <label className="font-semibold">スポーツ種別</label>
              <div className="text-gray-800">{sportAffiliationLabel}</div>
            </div>
            <div>
              <label className="font-semibold">チーム名</label>
              <div className="text-gray-800">{teamName}</div>
            </div>
            <div>
              <label className="font-semibold">チーム紹介SNS</label>
              <div className="text-blue-600 underline break-all">{teamUrl}</div>
            </div>
            <div>
              <label className="font-semibold">活動エリア（都道府県）</label>
              <div className="text-gray-800">{prefectureLabel}</div>
            </div>
            <div>
              <label className="font-semibold">市町村区</label>
              <div className="text-gray-800">{address}</div>
            </div>
            {teamLogoUrl && (
              <div>
                <label className="font-semibold">チームロゴ</label>
                <div>
                  <img
                    src={teamLogoUrl}
                    alt="Team Logo"
                    className="w-32 h-auto mt-2 border rounded"
                  />
                </div>
              </div>
            )}
          </div>
        </div>

        <div className="flex justify-between">
          <button
            type="button"
            onClick={handleBack}
            className="inline-block bg-gray-300 hover:bg-gray-400 text-black py-2 px-6 rounded"
          >
            戻る
          </button>

          <button
            type="submit"
            disabled={processing}
            className="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded font-semibold"
          >
            登録する
          </button>
        </div>
      </form>
    </div>
  );
}
