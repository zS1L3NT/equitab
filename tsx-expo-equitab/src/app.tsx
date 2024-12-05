import { RootStackNavigation } from "@/navigation"
import ErrorScreen from "@/ui/screens/error"
import { NavigationContainer } from "@react-navigation/native"
import ErrorBoundary from "react-native-error-boundary"
import { SafeAreaProvider } from "react-native-safe-area-context"
import "@/global.css"

export default function App() {
	return (
		<ErrorBoundary FallbackComponent={ErrorScreen}>
			<SafeAreaProvider>
				<NavigationContainer>
					<RootStackNavigation />
				</NavigationContainer>
			</SafeAreaProvider>
		</ErrorBoundary>
	)
}
