import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import { PageProps } from '@/types';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import duration from 'dayjs/plugin/duration';
import InviteCard from '@/Components/InviteCard';

dayjs.extend(duration);
dayjs.locale('ja');

interface Team {
  id: string;
  name: string;
  image?: {
    path_base64: string;
  };
}

interface InviteData {
  id: string;
  created_at: string;
  consent_status: number;
  first_preferered_date: string;
  second_preferered_date?: string;
  third_preferered_date?: string;
  unread?: boolean;
  team: Team;
  game_date?: string | null;
}

interface Props extends PageProps {
  myTeam: Team | null;
  myTeamInvites: InviteData[];
  asGuestInvites: InviteData[];
  inviteStatuses: Record<number, string>;
  message?: {
    success?: string;
  };
}

export default function TeamInvitations({
  myTeam,
  myTeamInvites,
  asGuestInvites,
  inviteStatuses,
  message,
}: Props) {
  const markAsRead = (id: string) => {
    router.post(route('myteam.markAsRead', id));
  };

  return (
    <AuthenticatedLayout>
      <Head title="チーム招待状況" />

      <div className="max-w-7xl mx-auto py-8 px-4">
        {message?.success && (
          <div className="mb-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-md shadow-sm transition-opacity duration-500 ease-in-out">
            {message.success}
          </div>
        )}

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
          <>
            <h2 className="text-lg font-semibold border-b pb-2 text-blue-700 mb-4">あなたが招待したチーム</h2>
            <ul className="flex flex-wrap gap-6 justify-center">
              {myTeamInvites.length > 0 ? (
                myTeamInvites.map((invite) => (
                  <InviteCard key={invite.id} invite={invite} inviteStatuses={inviteStatuses} />
                ))
              ) : (
                <p className="text-gray-500">まだ招待したチームはありません。</p>
              )}
            </ul>

            <h2 className="text-lg font-semibold border-b pb-2 text-green-700 mt-12 mb-4">あなたを招待したチーム</h2>
            <ul className="flex flex-wrap gap-6 justify-center">
              {asGuestInvites.length > 0 ? (
                asGuestInvites.map((invite) => (
                  <InviteCard key={invite.id} invite={invite} inviteStatuses={inviteStatuses} />
                ))
              ) : (
                <p className="text-gray-500">まだ招待されているチームはありません。</p>
              )}
            </ul>
          </>
        )}
      </div>
    </AuthenticatedLayout>
  );
}
