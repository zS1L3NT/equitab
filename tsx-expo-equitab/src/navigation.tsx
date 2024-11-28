import { AppIcon } from "@/config/theme"
import AddFriendsModal from "@/modals/add-friends"
import CreateLedgerModal from "@/modals/create-ledger"
import FriendsScreen from "@/screens/friends"
import HomeScreen from "@/screens/home"
import SettingsScreen from "@/screens/settings"
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs"
import { createNativeStackNavigator } from "@react-navigation/native-stack"

const RootStack = createNativeStackNavigator<RootStackParamList>()
export type RootStackParamList = Record<"App" | "AddFriends" | "CreateLedger", undefined>
export function RootStackNavigation() {
	return (
		<RootStack.Navigator screenOptions={{ headerShown: false }}>
			<RootStack.Screen name="App" component={RootTabNavigation} />
			<RootStack.Screen
				name="CreateLedger"
				component={CreateLedgerModal}
				options={{
					presentation: "modal",
					headerShown: true,
				}}
			/>
			<RootStack.Screen
				name="AddFriends"
				component={AddFriendsModal}
				options={{
					presentation: "modal",
					headerShown: true,
				}}
			/>
		</RootStack.Navigator>
	)
}

const RootTab = createBottomTabNavigator<RootTabParamList>()
export type RootTabParamList = Record<"Home" | "Friends" | "Settings", undefined>
export function RootTabNavigation() {
	return (
		<RootTab.Navigator initialRouteName="Home">
			<RootTab.Screen
				name="Home"
				component={HomeScreen}
				options={{ tabBarIcon: props => <AppIcon name="home" {...props} /> }}
			/>
			<RootTab.Screen
				name="Friends"
				component={FriendsScreen}
				options={{ tabBarIcon: props => <AppIcon name="people" {...props} /> }}
			/>
			<RootTab.Screen
				name="Settings"
				component={SettingsScreen}
				options={{ tabBarIcon: props => <AppIcon name="settings" {...props} /> }}
			/>
		</RootTab.Navigator>
	)
}
