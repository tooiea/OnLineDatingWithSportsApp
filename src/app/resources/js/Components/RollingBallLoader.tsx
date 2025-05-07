import { Player } from '@lottiefiles/react-lottie-player';

export default function RollingBallLoader() {
  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-white/70 backdrop-blur-sm">
      <Player
        autoplay
        loop
        src="/animations/rolling_baseball.json"
        style={{ height: '120px', width: '120px' }}
      />
    </div>
  );
}
