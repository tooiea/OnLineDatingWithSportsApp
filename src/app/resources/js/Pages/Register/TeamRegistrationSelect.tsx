import React from 'react';
import { router } from '@inertiajs/react';

const TeamRegistrationSelect: React.FC = () => {
  const handleCreateTeam = () => {
    router.visit(route('register.team.index'));
  };

  const handleJoinTeam = () => {
    router.visit(route('register.team.join.index'));
  };

  return (
    <div className="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-green-100 overflow-hidden px-4 py-12">
      {/* ボールの装飾 */}
      <img
        src="/images/ball-soccer.png"
        alt="Soccer Ball"
        className="absolute top-4 left-4 w-20 md:w-20 lg:w-24"
      />
      <img
        src="/images/ball-baseball.png"
        alt="Baseball"
        className="absolute top-6 right-4 w-16 md:w-16 lg:w-20"
      />
      <img
        src="/images/ball-volleyball.png"
        alt="Volleyball"
        className="absolute bottom-4 left-4 w-24 md:w-20 lg:w-24"
      />
      <img
        src="/images/ball-basketball.png"
        alt="Basketball"
        className="absolute bottom-6 right-4 w-20 md:w-20 lg:w-24"
      />

      {/* メインコンテンツ */}
      <div className="text-center space-y-6 z-10">
        <img
          src="/images/logo.png"
          alt="OLDWS Logo"
          className="mx-auto w-20 md:w-28"
        />
        <h1 className="text-xl md:text-3xl font-extrabold text-gray-800">
          ようこそ、<span className="text-blue-700">OLDWS</span>へ！<br />
          チームに参加しよう！
        </h1>
        <p className="text-blue-600 font-semibold text-sm md:text-base">スポーツでつながる</p>

        <div className="space-y-4">
          <button
            onClick={handleCreateTeam}
            className="bg-blue-600 hover:bg-blue-700 text-white text-sm md:text-base font-bold py-3 px-8 rounded-full shadow-md"
          >
            新しくチームを作る
          </button>
          <br />
          <button
            onClick={handleJoinTeam}
            className="bg-green-500 hover:bg-green-600 text-white text-sm md:text-base font-bold py-3 px-8 rounded-full shadow-md"
          >
            チームに参加する
          </button>
        </div>
      </div>
    </div>
  );
};

export default TeamRegistrationSelect;
