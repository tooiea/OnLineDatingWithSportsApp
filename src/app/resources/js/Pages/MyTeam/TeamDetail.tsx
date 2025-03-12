import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { useState } from 'react';

interface Team {
  id: string;
  name: string;
  logo: string;
  extension: string;
  team_url?: string;
  code: string;
}

interface Props extends PageProps {
  myTeam?: { team?: Team };
  teamMembersNumber: number;
}

export default function TeamDetail({ auth, myTeam, teamMembersNumber }: Props) {
  const [copySuccess, setCopySuccess] = useState(false);
  console.log('myTeam:', myTeam);
  const inviteUrl = myTeam?.team?.code
    ? route('temp_register.team.join.index', myTeam.team.code)
    : '';

  const handleCopy = async () => {
    try {
      await navigator.clipboard.writeText(inviteUrl);
      setCopySuccess(true);
      setTimeout(() => setCopySuccess(false), 3000);
    } catch (error) {
      console.error('コピーに失敗しました:', error);
    }
  };

  if (!myTeam?.team) {
    return <div className="container mx-auto my-10 px-4">Loading...</div>;
  }

  return (
    <AuthenticatedLayout>
      <Head title="チームプロフィール詳細" />

      <div className="container mx-auto my-10 px-4">
        <div className="bg-white shadow rounded-lg p-6">
          <h3 className="text-2xl font-semibold border-b pb-3 mb-5">チームプロフィール詳細</h3>

          <div className="mb-4">
            <h5 className="font-semibold">チーム名</h5>
            <p>{myTeam.team.name}</p>
          </div>

          {myTeam.team.logo && (
            <div className="mb-4">
              <img
                src={`data:${myTeam.team.extension};base64,${myTeam.team.logo}`}
                className="max-w-xs h-auto"
                alt="team logo"
              />
            </div>
          )}

          <div className="mb-4">
            <h5 className="font-semibold">登録人数</h5>
            <p>{teamMembersNumber}人</p>
          </div>

          <div className="mb-4">
            <h5 className="font-semibold">チーム紹介URL</h5>
            {myTeam.team.team_url ? (
              <a href={myTeam.team.team_url} className="text-indigo-500 hover:underline">
                {myTeam.team.team_url}
              </a>
            ) : (
              <p>-</p>
            )}
          </div>

          <div className="mb-4">
            <h5 className="font-semibold">他選手の招待URL</h5>
            {inviteUrl ? (
              <div className="flex items-center">
                <input
                  type="text"
                  value={inviteUrl}
                  readOnly
                  className="form-input flex-grow border-gray-300 rounded-md"
                />
                <button
                  onClick={handleCopy}
                  className="ml-2 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                >
                  コピー
                </button>
              </div>
            ) : (
              <p className="text-gray-500">招待URLが設定されていません。</p>
            )}
            {copySuccess && <div className="mt-2 text-green-600">コピーしました</div>}
          </div>

          {/* TODO: アルバム画像の実装 */}
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
