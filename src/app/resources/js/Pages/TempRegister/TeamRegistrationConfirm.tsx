import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import LabelBlock from '@/Components/LabelBlock';

interface Props {
  sportAffiliationType: string;
  sportAffiliationLabel: string;
  teamName: string;
  teamUrl: string;
  prefecture: string;
  prefectureLabel: string;
  address: string;
  nickname: string;
  email: string;
  teamLogoUrl?: string;
  routes: {
    complete: string;
    back: string;
  }
}

export default function TeamRegistrationConfirm({
  sportAffiliationLabel,
  teamName,
  teamUrl,
  prefectureLabel,
  address,
  nickname,
  email,
  teamLogoUrl,
  routes,
}: Props) {
  const { post, processing } = useForm({});

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.complete, {
      forceFormData: true,
    });
  };

  const handleBack = (e: React.FormEvent) => {
    e.preventDefault();
    post(routes.back, {
      forceFormData: true,
    });
  };

  return (
    <div className="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen py-10 px-4">
      <Head title="登録内容の確認" />

      <h1 className="text-2xl font-bold text-center mb-8">チーム登録内容の確認</h1>

      <div className="max-w-3xl mx-auto px-4">
        <form onSubmit={handleSubmit} className="space-y-8">
          <div className="bg-white shadow-md rounded-lg p-6">
            <h2 className="text-lg font-semibold border-b pb-2 mb-4">👤 ユーザー情報</h2>
            <div className="space-y-4">
              <LabelBlock label="ニックネーム">{nickname}</LabelBlock>
              <LabelBlock label="メールアドレス">{email}</LabelBlock>
              <LabelBlock label="パスワード">
                <span className="text-gray-400">********</span>
              </LabelBlock>
            </div>
          </div>

          <div className="bg-white shadow-md rounded-lg p-6">
            <h2 className="text-lg font-semibold border-b pb-2 mb-4">🏆 チーム情報</h2>
            <div className="space-y-4">
              <LabelBlock label="スポーツ種別">{sportAffiliationLabel}</LabelBlock>
              <LabelBlock label="チーム名">{teamName}</LabelBlock>
              <LabelBlock label="チーム紹介SNS">
                {teamUrl ? (
                  <a
                    href={teamUrl}
                    className="text-blue-600 underline break-all"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    {teamUrl}
                  </a>
                ) : (
                  <span className="text-gray-400">-</span>
                )}
              </LabelBlock>
              <LabelBlock label="活動エリア（都道府県）">{prefectureLabel}</LabelBlock>
              <LabelBlock label="市町村区">{address}</LabelBlock>
              {teamLogoUrl && (
                <LabelBlock label="チームロゴ">
                  <img
                    src={teamLogoUrl}
                    alt="Team Logo"
                    className="w-32 h-auto mt-2 border rounded"
                  />
                </LabelBlock>
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
    </div>
  );
}
