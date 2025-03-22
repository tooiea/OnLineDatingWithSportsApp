import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import { PageProps } from '@/types';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';

dayjs.locale('ja');

interface Invite {
  id: string;
  created_at: string;
  consent_status: number;
  first_preferered_date: string;
  second_preferered_date?: string;
  third_preferered_date?: string;
  guest: {
    id: string;
    name: string;
    image?: {
      path_base64: string;
    };
  };
}

interface Guest {
  id: string;
  created_at: string;
  consent_status: number;
  first_preferered_date: string;
  second_preferered_date?: string;
  third_preferered_date?: string;
  invitee: {
    id: string;
    name: string;
    image?: {
      path_base64: string;
    };
  };
}

interface Props extends PageProps {
  myTeam: { name: string; id: string } | null;
  myTeamInvites: Invite[];
  asGuestInvites: Guest[];
}

// 日付フォーマット関数（「2025年01月13日（金）」の形式）
const formatFullDate = (date?: string) =>
  date ? dayjs(date).format('YYYY年MM月DD日（ddd）') : 'ー';

// 時間フォーマット関数（「17:00～」の形式）
const formatTime = (date?: string) =>
  date ? `${dayjs(date).format('HH:mm')}～` : 'ー';

export default function TeamInvitations({ myTeam, myTeamInvites, asGuestInvites }: Props) {
  const markAsRead = (id: string) => {
    router.post(route('myteam.markAsRead', id));
  };

  return (
    <AuthenticatedLayout>
      <Head title="チーム招待状況" />

      <div className="max-w-4xl mx-auto py-8 px-4"> {/* PC版の横幅を縮小 */}
        {/* チーム未登録時の動線 */}
        {!myTeam ? (
          <div className="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 className="text-xl font-semibold">チームに所属していません</h2>
            <p className="text-gray-500">まずはチームを登録するか、招待を受け取って参加しましょう。</p>
            <div className="mt-4">
              <Link
                href={route('new_team.index')}
                className="bg-green-500 text-white px-4 py-2 rounded-md shadow hover:bg-green-600"
              >
                チームを登録する
              </Link>
            </div>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {/* あなたが招待したチーム */}
            <div>
              <h2 className="text-lg font-semibold border-b pb-2 text-blue-700">あなたが招待したチーム</h2>
              <ul className="mt-4 space-y-4">
                {myTeamInvites.length > 0 ? (
                  myTeamInvites.map((invite) => (
                    <li key={invite.id} className="bg-blue-50 shadow-lg p-6 rounded-lg">
                      <div className="text-xl font-bold mb-2">{invite.guest.name}</div>
                      {invite.guest.image && (
                        <img src={invite.guest.image.path_base64} alt="チーム画像" className="w-full h-40 object-cover rounded-lg mb-4" />
                      )}
                      <h3 className="text-md font-semibold">希望日程</h3>
                      <ul className="text-gray-600 space-y-2">
                        {[
                          { label: '①', date: invite.first_preferered_date },
                          { label: '②', date: invite.second_preferered_date },
                          { label: '③', date: invite.third_preferered_date }
                        ].map(({ label, date }) => (
                          <li key={label} className="flex">
                            <span className="font-semibold">{label} </span>
                            <span className="ml-2">
                              {formatFullDate(date)} {formatTime(date)}
                            </span>
                          </li>
                        ))}
                      </ul>
                      <div className="mt-2">
                        <Link href={route('myteam.consent_game.detail', invite.id)} className="text-indigo-500 hover:underline">
                          招待詳細を見る
                        </Link>
                      </div>
                    </li>
                  ))
                ) : (
                  <p className="text-gray-500">まだ招待したチームはありません。</p>
                )}
              </ul>
            </div>

            {/* あなたを招待したチーム */}
            <div>
              <h2 className="text-lg font-semibold border-b pb-2 text-green-700">あなたを招待したチーム</h2>
              <ul className="mt-4 space-y-4">
                {asGuestInvites.length > 0 ? (
                  asGuestInvites.map((invite) => (
                    <li key={invite.id} className="bg-green-50 shadow-lg p-6 rounded-lg">
                      <div className="text-xl font-bold mb-2">{invite.invitee.name}</div>
                      {invite.invitee.image && (
                        <img src={invite.invitee.image.path_base64} alt="チーム画像" className="w-full h-40 object-cover rounded-lg mb-4" />
                      )}
                      <h3 className="text-md font-semibold">希望日程</h3>
                      <ul className="text-gray-600 space-y-2">
                        {[
                          { label: '①', date: invite.first_preferered_date },
                          { label: '②', date: invite.second_preferered_date },
                          { label: '③', date: invite.third_preferered_date }
                        ].map(({ label, date }) => (
                          <li key={label} className="flex">
                            <span className="font-semibold">{label} </span>
                            <span className="ml-2">
                              {formatFullDate(date)} {formatTime(date)}
                            </span>
                          </li>
                        ))}
                      </ul>
                      <div className="mt-2">
                        <Link href={route('myteam.consent_game.detail', invite.id)} onClick={() => markAsRead(invite.id)} className="text-indigo-500 hover:underline">
                          招待詳細を見る
                        </Link>
                      </div>
                    </li>
                  ))
                ) : (
                  <p className="text-gray-500">まだ招待されているチームはありません。</p>
                )}
              </ul>
            </div>
          </div>
        )}
      </div>
    </AuthenticatedLayout>
  );
}
