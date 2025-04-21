import React, { useEffect, useState } from 'react';
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

  const [showSuccess, setShowSuccess] = useState(!!message?.success);
  const [tab, setTab] = useState<'sent' | 'received'>('sent');

  useEffect(() => {
    if (showSuccess) {
      const timer = setTimeout(() => {
        setShowSuccess(false);
      }, 3000);
      return () => clearTimeout(timer);
    }
  }, [showSuccess]);

  return (
    <AuthenticatedLayout>
      <Head title="チーム招待状況" />

      <div className="max-w-7xl mx-auto py-8 px-4">
        {showSuccess && (
          <div className="mb-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-md shadow-sm transition-opacity duration-300 ease-in-out">
            {message?.success}
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
            <div className="flex justify-center gap-4 mb-6">
              <button
                onClick={() => setTab('sent')}
                className={`px-4 py-2 rounded-md text-sm font-medium border-b-2 ${
                  tab === 'sent' ? 'text-indigo-600 border-indigo-600' : 'text-gray-500 border-transparent'
                }`}
              >
                送った招待
              </button>
              <button
                onClick={() => setTab('received')}
                className={`px-4 py-2 rounded-md text-sm font-medium border-b-2 ${
                  tab === 'received' ? 'text-indigo-600 border-indigo-600' : 'text-gray-500 border-transparent'
                }`}
              >
                受けた招待
              </button>
            </div>

            {tab === 'sent' ? (
              <>
                <ul className="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                  {myTeamInvites.length > 0 ? (
                    myTeamInvites.map((invite) => (
                      <InviteCard key={invite.id} invite={invite} inviteStatuses={inviteStatuses} isInviter={true} />
                    ))
                  ) : (
                    <p className="text-gray-500">招待したチームはまだありません。</p>
                  )}
                </ul>
              </>
            ) : (
              <>
                <ul className="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                  {asGuestInvites.length > 0 ? (
                    asGuestInvites.map((invite) => (
                      <InviteCard key={invite.id} invite={invite} inviteStatuses={inviteStatuses} isInviter={false} />
                    ))
                  ) : (
                    <p className="text-gray-500">招待されたチームはまだありません。</p>
                  )}
                </ul>
              </>
            )}
          </>
        )}
      </div>
    </AuthenticatedLayout>
  );
}
