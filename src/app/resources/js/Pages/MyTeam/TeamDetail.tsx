import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { useState, useEffect } from 'react';

interface Team {
  id: string;
  name: string;
  logo: string;
  extension: string;
  team_url?: string;
  code: string;
  prefectureLabel?: string;
  address?: string;
  favoriteFacility?: string;
}

interface AlbumImage {
  id: number;
  path_base64: string;
}

interface Album {
  id: string;
  name: string;
  images: AlbumImage[];
}

interface Prefecture {
  value: number;
  label: string;
}

interface Props extends PageProps {
  myTeam?: { team?: Team };
  teamMembersNumber: number;
  albums: Album[];
  message?: {
    success?: string;
  };
}

export default function TeamDetail({ auth, myTeam, teamMembersNumber, albums, message }: Props) {
  const [copySuccess, setCopySuccess] = useState(false);
  const [visibleMessage, setVisibleMessage] = useState<string | null>(message?.success ?? null);

  useEffect(() => {
    if (message?.success) {
      setVisibleMessage(message.success);
      const timer = setTimeout(() => setVisibleMessage(null), 3000);
      return () => clearTimeout(timer);
    }
  }, [message]);

  const inviteUrl = myTeam?.team?.code
    ? route('temp_register.team.join.index', myTeam.team.code)
    : '';

  const teamEditUrl = route('myteam.edit');

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

      <div className="max-w-4xl mx-auto px-4 py-10">
        {visibleMessage && (
          <div className="mb-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-md shadow-sm transition-opacity duration-500 ease-in-out">
            {visibleMessage}
          </div>
        )}

        <div className="bg-white shadow-lg rounded-xl p-6 md:p-8">
          <h3 className="text-xl font-bold border-b pb-3 mb-6">チームプロフィール詳細</h3>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <div className="space-y-4">
              <div>
                <p className="text-sm font-semibold text-gray-600">チーム名</p>
                <p className="text-gray-800">
                  <a href={teamEditUrl} className="text-indigo-500 hover:underline break-all">
                    {myTeam.team.name}
                  </a>
                </p>
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">都道府県</p>
                <p className="text-gray-800">{myTeam.team.prefectureLabel}</p>
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">住所</p>
                <p className="text-gray-800">{myTeam.team.address || '-'}</p>
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">よく使う施設名</p>
                <p className="text-gray-800">{myTeam.team.favoriteFacility || '-'}</p>
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">登録人数</p>
                <p className="text-gray-800">{teamMembersNumber}人</p>
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">チーム紹介URL</p>
                {myTeam.team.team_url ? (
                  <a href={myTeam.team.team_url} className="text-indigo-500 hover:underline break-all">
                    {myTeam.team.team_url}
                  </a>
                ) : (
                  <p className="text-gray-500">-</p>
                )}
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">他選手の招待URL</p>
                {inviteUrl ? (
                  <div className="flex items-center gap-2">
                    <input
                      type="text"
                      value={inviteUrl}
                      readOnly
                      className="flex-1 border border-gray-300 rounded-md px-2 py-1 text-sm"
                    />
                    <button
                      onClick={handleCopy}
                      className="px-3 py-1 text-sm bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200"
                    >
                      コピー
                    </button>
                  </div>
                ) : (
                  <p className="text-gray-500 text-sm">招待URLが設定されていません。</p>
                )}
                {copySuccess && <p className="text-green-600 text-sm mt-2">コピーしました</p>}
              </div>
            </div>

            <div className="flex justify-center md:justify-end">
              {myTeam.team.logo && (
                <img
                  src={`data:${myTeam.team.extension};base64,${myTeam.team.logo}`}
                  alt="team logo"
                  className="w-48 h-48 object-cover rounded-lg border"
                />
              )}
            </div>
          </div>
        </div>

        {/* アルバム一覧 */}
        {albums.length > 0 && (
          <div className="bg-white shadow-lg rounded-xl p-6 mt-8">
            <h3 className="text-xl font-bold border-b pb-3 mb-6">アルバム</h3>

            {albums.length === 0 ? (
              <p className="text-gray-500">アルバムはまだ作成されていません。</p>
            ) : (
              albums.map((album) => (
                <div key={album.id} className="mb-8">
                  <h4 className="text-md font-semibold text-gray-800 mb-3">{album.name}</h4>
                  {album.images.length === 0 ? (
                    <div className="flex justify-center">
                      <img
                        src="/images/no_image.png"
                        alt="画像未登録"
                        className="w-32 h-32 object-contain opacity-60"
                      />
                    </div>
                  ) : (
                    <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                      {album.images.map((img) => (
                        <div key={img.id}>
                          <img
                            src={img.path_base64}
                            alt="アルバム画像"
                            className="w-full h-24 object-cover rounded border"
                          />
                        </div>
                      ))}
                    </div>
                  )}
                </div>
              ))
            )}
          </div>
        )}
      </div>
    </AuthenticatedLayout>
  );
}
